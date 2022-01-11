<?php

namespace App\Service;

use App\Entity\Member;
use App\Entity\MemberStatus;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader as CsvReader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CsvToMemberService
{
    public const LOCAL_IDENTIFIER_HEADER = 'localIdentifier';
    public const EXTERNAL_IDENTIFIER_HEADER = 'externalIdentifier';
    public const FIRST_NAME_HEADER = 'firstName';
    public const MIDDLE_NAME_HEADER = 'middleName';
    public const PREFERRED_NAME_HEADER = 'preferredName';
    public const LAST_NAME_HEADER = 'lastName';
    public const STATUS_HEADER = 'status';
    public const BIRTH_DATE_HEADER = 'birthDate';
    public const JOIN_DATE_HEADER = 'joinDate';
    public const CLASS_YEAR_HEADER = 'classYear';
    public const DECEASED_HEADER = 'isDeceased';
    public const EMPLOYER_HEADER = 'employer';
    public const JOB_TITLE_HEADER = 'jobTitle';
    public const OCCUPATION_HEADER = 'occupation';
    public const PRIMARY_EMAIL_HEADER = 'primaryEmail';
    public const PRIMARY_TELEPHONE_NUMBER_HEADER = 'primaryTelephoneNumber';
    public const MAILING_ADDRESS_HEADER = 'mailingAddress';
    public const MAILING_ADDRESS_LINE1_HEADER = 'mailingAddressLine1';
    public const MAILING_ADDRESS_LINE2_HEADER = 'mailingAddressLine2';
    public const MAILING_CITY_HEADER = 'mailingCity';
    public const MAILING_STATE_HEADER = 'mailingState';
    public const MAILING_POSTAL_CODE_HEADER = 'mailingPostalCode';
    public const MAILING_COUNTRY_HEADER = 'mailingCountry';
    public const MAILING_LATITUDE_HEADER = 'mailingLatitude';
    public const MAILING_LONGITUDE_HEADER = 'mailingLongitude';
    public const LOST_HEADER = 'isLost';
    public const LOCAL_DO_NOT_CONTACT_HEADER = 'isLocalDoNotContact';
    public const DIRECTORY_NOTES_HEADER = 'directoryNotes';

    protected $entityManager;

    protected $validator;

    protected $memberStatusMap;

    protected $members = [];

    protected $errors = [];

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->loadMemberStatusMapping();
    }

    public function getMembers()
    {
        return $this->members;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function run(UploadedFile $file)
    {
        // Ensure a file is selected
        if (!$file->isValid()) {
            throw new \Exception('Uploaded file is invalid.');
        }

        // Parse loaded file
        $csv = CsvReader::createFromPath($file->getPath().DIRECTORY_SEPARATOR.$file->getFileName(), 'r');
        $csv->setHeaderOffset(0);

        // Main import loop
        foreach ($csv->getRecords() as $i => $csvRecord) {
            $externalIdentifier = (isset($csvRecord[self::EXTERNAL_IDENTIFIER_HEADER])) ? $csvRecord[self::EXTERNAL_IDENTIFIER_HEADER] : null;
            $localIdentifier = (isset($csvRecord[self::LOCAL_IDENTIFIER_HEADER])) ? $csvRecord[self::LOCAL_IDENTIFIER_HEADER] : null;
            $firstName = (isset($csvRecord[self::FIRST_NAME_HEADER])) ? $csvRecord[self::FIRST_NAME_HEADER] : null;
            $lastName = (isset($csvRecord[self::LAST_NAME_HEADER])) ? $csvRecord[self::LAST_NAME_HEADER] : null;

            $member = $this->entityManager->getRepository(Member::class)->findOneBy([
                'externalIdentifier' => $externalIdentifier,
            ]);

            if (null === $member) {
                $member = $this->entityManager->getRepository(Member::class)->findOneBy([
                    'localIdentifier' => $localIdentifier,
                ]);
            }

            if (null === $member) {
                $member = $this->entityManager->getRepository(Member::class)->findOneBy([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                ]);
            }

            if (null === $member) {
                $member = new Member();
            }

            // Populate fields if set
            if (isset($csvRecord[self::EXTERNAL_IDENTIFIER_HEADER])) {
                $member->setExternalIdentifier($csvRecord[self::EXTERNAL_IDENTIFIER_HEADER]);
            }
            if (isset($csvRecord[self::LOCAL_IDENTIFIER_HEADER])) {
                $member->setLocalIdentifier($csvRecord[self::LOCAL_IDENTIFIER_HEADER]);
            }
            if (isset($csvRecord[self::FIRST_NAME_HEADER])) {
                $member->setFirstName($csvRecord[self::FIRST_NAME_HEADER]);
            }
            if (isset($csvRecord[self::PREFERRED_NAME_HEADER])) {
                $member->setPreferredName($csvRecord[self::PREFERRED_NAME_HEADER]);
            }
            if (isset($csvRecord[self::MIDDLE_NAME_HEADER])) {
                if (null != $member->getMiddleName() || '' != $csvRecord[self::MIDDLE_NAME_HEADER]) {
                    $member->setMiddleName($csvRecord[self::MIDDLE_NAME_HEADER]);
                }
            }
            if (isset($csvRecord[self::LAST_NAME_HEADER])) {
                $member->setLastName($csvRecord[self::LAST_NAME_HEADER]);
            }
            if (isset($csvRecord[self::BIRTH_DATE_HEADER]) && strtotime($csvRecord[self::BIRTH_DATE_HEADER])) {
                $member->setBirthDate(new \DateTime($csvRecord[self::BIRTH_DATE_HEADER]));
            }
            if (isset($csvRecord[self::JOIN_DATE_HEADER]) && strtotime($csvRecord[self::JOIN_DATE_HEADER])) {
                $member->setJoinDate(new \DateTime($csvRecord[self::JOIN_DATE_HEADER]));
            }
            if (isset($csvRecord[self::CLASS_YEAR_HEADER]) && $csvRecord[self::CLASS_YEAR_HEADER]) {
                if (null != $member->getClassYear() || 0 != $csvRecord[self::CLASS_YEAR_HEADER]) {
                    $member->setClassYear((int) $csvRecord[self::CLASS_YEAR_HEADER]);
                }
            }
            if (isset($csvRecord[self::DECEASED_HEADER])) {
                $member->setIsDeceased($this->formatBoolean($csvRecord[self::DECEASED_HEADER]));
            }
            if (isset($csvRecord[self::EMPLOYER_HEADER])) {
                if (null != $member->getEmployer() || '' != $csvRecord[self::EMPLOYER_HEADER]) {
                    $member->setEmployer($csvRecord[self::EMPLOYER_HEADER]);
                }
            }
            if (isset($csvRecord[self::JOB_TITLE_HEADER])) {
                if (null != $member->getJobTitle() || '' != $csvRecord[self::JOB_TITLE_HEADER]) {
                    $member->setJobTitle($csvRecord[self::JOB_TITLE_HEADER]);
                }
            }
            if (isset($csvRecord[self::OCCUPATION_HEADER])) {
                if (null != $member->getOccupation() || '' != $csvRecord[self::OCCUPATION_HEADER]) {
                    $member->setOccupation($csvRecord[self::OCCUPATION_HEADER]);
                }
            }
            if (isset($csvRecord[self::PRIMARY_EMAIL_HEADER]) && $csvRecord[self::PRIMARY_EMAIL_HEADER]) {
                $member->setPrimaryEmail($csvRecord[self::PRIMARY_EMAIL_HEADER]);
            }
            if (isset($csvRecord[self::PRIMARY_TELEPHONE_NUMBER_HEADER]) && $csvRecord[self::PRIMARY_TELEPHONE_NUMBER_HEADER]) {
                $member->setPrimaryTelephoneNumber($csvRecord[self::PRIMARY_TELEPHONE_NUMBER_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_ADDRESS_HEADER]) && $csvRecord[self::MAILING_ADDRESS_HEADER]) {
                $addressLines = explode("\n", $csvRecord[self::MAILING_ADDRESS_HEADER]);
                $member->setMailingAddressLine1($addressLines[0]);
                $member->setMailingAddressLine2(isset($addressLines[1]) ? $addressLines[1] : '');
            }
            if (isset($csvRecord[self::MAILING_ADDRESS_LINE1_HEADER]) && $csvRecord[self::MAILING_ADDRESS_LINE1_HEADER]) {
                $member->setMailingAddressLine1($csvRecord[self::MAILING_ADDRESS_LINE1_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_ADDRESS_LINE2_HEADER]) && $csvRecord[self::MAILING_ADDRESS_LINE2_HEADER]) {
                $member->setMailingAddressLine2($csvRecord[self::MAILING_ADDRESS_LINE2_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_CITY_HEADER]) && $csvRecord[self::MAILING_CITY_HEADER]) {
                $member->setMailingCity($csvRecord[self::MAILING_CITY_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_STATE_HEADER]) && $csvRecord[self::MAILING_STATE_HEADER]) {
                $member->setMailingState($csvRecord[self::MAILING_STATE_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_POSTAL_CODE_HEADER]) && $csvRecord[self::MAILING_POSTAL_CODE_HEADER]) {
                $member->setMailingPostalCode($csvRecord[self::MAILING_POSTAL_CODE_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_COUNTRY_HEADER]) && $csvRecord[self::MAILING_COUNTRY_HEADER]) {
                $mailingCountry = $csvRecord[self::MAILING_COUNTRY_HEADER];
                if ('US' == $mailingCountry) {
                    $mailingCountry = 'United States';
                }
                $member->setMailingCountry($mailingCountry);
            }
            if (isset($csvRecord[self::MAILING_LATITUDE_HEADER]) && $csvRecord[self::MAILING_LATITUDE_HEADER]) {
                $member->setMailingLatitude($csvRecord[self::MAILING_LATITUDE_HEADER]);
            }
            if (isset($csvRecord[self::MAILING_LONGITUDE_HEADER]) && $csvRecord[self::MAILING_LONGITUDE_HEADER]) {
                $member->setMailingLongitude($csvRecord[self::MAILING_LONGITUDE_HEADER]);
            }
            if (isset($csvRecord[self::LOST_HEADER])) {
                $member->setIsLost($this->formatBoolean($csvRecord[self::LOST_HEADER]));
            }
            if (isset($csvRecord[self::LOCAL_DO_NOT_CONTACT_HEADER])) {
                $member->setIsLocalDoNotContact($this->formatBoolean($csvRecord[self::LOCAL_DO_NOT_CONTACT_HEADER]));
            }
            if (isset($csvRecord[self::DIRECTORY_NOTES_HEADER])) {
                $member->setDirectoryNotes($csvRecord[self::DIRECTORY_NOTES_HEADER]);
            }
            if (isset($csvRecord[self::STATUS_HEADER])) {
                if (!isset($this->memberStatusMap[$csvRecord[self::STATUS_HEADER]])) {
                    $this->errors[] = sprintf(
                        '[%s|%s %s, %s] Unable to set status to "%s" (not mapped)',
                        $member->getExternalIdentifier(),
                        $member->getLocalIdentifier(),
                        $member->getLastName(),
                        $member->getPreferredName(),
                        $csvRecord[self::STATUS_HEADER]
                    );
                    continue;
                }
                $member->setStatus($this->memberStatusMap[$csvRecord[self::STATUS_HEADER]]);
            }
            // If elements empty, populate
            if (!$member->getPreferredName()) {
                $member->setPreferredName($member->getFirstName());
            }

            // Validate records
            $errors = $this->validator->validate($member);
            if (count($errors) > 0) {
                foreach ($errors->getIterator() as $error) {
                    $this->errors[$i] = sprintf(
                        '[%s|%s %s, %s] %s %s',
                        $member->getExternalIdentifier(),
                        $member->getLocalIdentifier(),
                        $member->getLastName(),
                        $member->getPreferredName(),
                        $error->getPropertyPath(),
                        $error->getMessage()
                    );
                }
                continue;
            }

            $this->members[$i] = $member;
        }
    }

    public function getAllowedHeaders(): array
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return array_values($oClass->getConstants());
    }

    private function formatBoolean($bool): bool
    {
        if (is_numeric($bool)) {
            return '1' == $bool;
        }

        if (is_string($bool)) {
            $bool = strtoupper($bool);
            switch ($bool) {
                case 'Y':
                case 'YES':
                case 'ACTIVE':
                case 'TRUE':
                case 'T':
                case 'CHECKED':
                    return true;
                default:
                    return false;
            }
        }

        return (bool) $bool;
    }

    private function loadMemberStatusMapping()
    {
        $memberStatuses = $this->entityManager->getRepository(MemberStatus::class)->findBy([]);
        foreach ($memberStatuses as $memberStatus) {
            $this->memberStatusMap[$memberStatus->getCode()] = $memberStatus;
            $this->memberStatusMap[$memberStatus->getLabel()] = $memberStatus;
        }
    }
}
