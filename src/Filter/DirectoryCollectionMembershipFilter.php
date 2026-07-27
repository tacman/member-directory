<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\FilterInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\DirectoryCollection;
use Doctrine\ORM\QueryBuilder;

/**
 * Filters members by DirectoryCollection membership.
 *
 * Membership is indirect: a member belongs to a collection through its
 * MemberStatus (Member -> status -> directoryCollections), not a direct
 * relation. Each DirectoryCollection can also independently force-include
 * or force-exclude lost / do-not-contact / deceased members via its own
 * filterLost / filterLocalDoNotContact / filterDeceased flags.
 *
 * Ported from MemberRepository::findByDirectoryCollection() so the /api/members
 * collection endpoint can serve the same "?directoryCollectionSlug=..." queries
 * that the old hand-rolled DirectoryController endpoints used to compute directly.
 */
class DirectoryCollectionMembershipFilter extends AbstractFilter implements FilterInterface
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = []
    ): void {
        if ('directoryCollectionSlug' !== $property || !\is_string($value) || '' === $value) {
            return;
        }

        $directoryCollection = $this->getManagerRegistry()
            ->getRepository(DirectoryCollection::class)
            ->findOneBy(['slug' => $value]);

        if (!$directoryCollection) {
            // Unknown slug: match nothing rather than silently returning the full set.
            $queryBuilder->andWhere('1 = 0');

            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $statusAlias = $queryNameGenerator->generateJoinAlias('status');
        $collectionAlias = $queryNameGenerator->generateJoinAlias('directoryCollections');

        $queryBuilder
            ->join(sprintf('%s.status', $rootAlias), $statusAlias)
            ->join(sprintf('%s.directoryCollections', $statusAlias), $collectionAlias)
            ->andWhere(sprintf('%s = :directory_collection_membership', $collectionAlias))
            ->setParameter('directory_collection_membership', $directoryCollection);

        if ($directoryCollection->getFilterLost()) {
            $queryBuilder->andWhere(sprintf('%s.isLost = :dc_is_lost', $rootAlias))
                ->setParameter('dc_is_lost', 'include' === $directoryCollection->getFilterLost());
        }
        if ($directoryCollection->getFilterLocalDoNotContact()) {
            $queryBuilder->andWhere(sprintf('%s.isLocalDoNotContact = :dc_is_do_not_contact', $rootAlias))
                ->setParameter('dc_is_do_not_contact', 'include' === $directoryCollection->getFilterLocalDoNotContact());
        }
        if ($directoryCollection->getFilterDeceased()) {
            $queryBuilder->andWhere(sprintf('%s.isDeceased = :dc_is_deceased', $rootAlias))
                ->setParameter('dc_is_deceased', 'include' === $directoryCollection->getFilterDeceased());
        }
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'directoryCollectionSlug' => [
                'type' => 'string',
                'required' => false,
                'description' => 'Filter members by DirectoryCollection slug (via MemberStatus membership).',
            ],
        ];
    }
}
