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
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route(path: '/admin/member-statuses/{memberStatusId}')]
class MemberStatusController extends AbstractController
{

    #[Route(path: '/', name: 'member_status_show', methods: ['GET'])]
    public function memberStatusShow(MemberStatus $memberStatus): Response
    {
        return $this->render('member_status/show.html.twig', [
            'member_status' => $memberStatus,
        ]);
    }

    #[Route(path: '/edit', name: 'member_status_edit', methods: ['GET', 'POST'])]
    public function memberStatusEdit(Request $request, MemberStatus $memberStatus, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MemberStatusType::class, $memberStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', sprintf('%s updated!', $memberStatus));

            return $this->redirectToRoute('member_status_index');
        }

        return $this->render('member_status/edit.html.twig', [
            'member_status' => $memberStatus,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/delete', name: 'member_status_delete', methods: ['POST'])]
    public function memberStatusDelete(Request $request, MemberStatus $memberStatus, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberStatus->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($memberStatus);
                $entityManager->flush();
                $this->addFlash('success', sprintf('%s deleted!', $memberStatus));
            } catch (ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', sprintf('Cannot delete %s because it is used by Members.', $memberStatus));
            }
        }

        return $this->redirectToRoute('member_status_index');
    }
}
