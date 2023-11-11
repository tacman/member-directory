<?php

namespace App\Controller;

use App\Entity\DirectoryCollection;
use App\Entity\MemberStatus;
use App\Form\MemberStatusType;
use App\Repository\MemberStatusRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route(path: '/admin/member-statuses')]
class MemberStatusCollectionController extends AbstractController
{
    #[Route(path: '/', name: 'member_status_index', methods: ['GET'])]
    public function memberStatus(MemberStatusRepository $memberStatusRepository): Response
    {
        return $this->render('member_status/index.html.twig', [
            'member_statuses' => $memberStatusRepository->findAll(),
        ]);
    }

    #[Route(path: '/new', name: 'member_status_new', methods: ['GET', 'POST'])]
    public function memberStatusNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memberStatus = new MemberStatus();
        $form = $this->createForm(MemberStatusType::class, $memberStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($memberStatus);
            $entityManager->flush();
            if ($form['createDirectoryCollection']->getData()) {
                try {
                    $directoryCollection = new DirectoryCollection();
                    $directoryCollection->setLabel($memberStatus->getLabel());
                    $directoryCollection->setIcon('fa-user');
                    $directoryCollection->setShowMemberStatus(false);
                    $directoryCollection->addMemberStatus($memberStatus);
                    $entityManager->persist($directoryCollection);
                    $entityManager->flush();
                    $this->addFlash('success', sprintf('%s created!', $memberStatus));
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Unable to create Directory Collection automatically.');
                }
            }

            return $this->redirectToRoute('member_status_index');
        }

        return $this->render('member_status/new.html.twig', [
            'member_status' => $memberStatus,
            'form' => $form->createView(),
        ]);
    }

}
