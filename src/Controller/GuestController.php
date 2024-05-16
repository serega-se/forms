<?php

namespace App\Controller;

use App\Entity\Guest;
use App\Form\GuestType;
use App\Repository\GuestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/guest')]
class GuestController extends AbstractController
{
    #[Route('/{_locale}/', name: 'app_guest_index', locale: 'en', methods: ['GET'])]
    public function index(GuestRepository $guestRepository): Response
    {
        return $this->render('guest/index.html.twig', [
            'guests' => $guestRepository->findAll(),
        ]);
    }

    #[Route('/{_locale}/new', name: 'app_guest_new', locale: 'en', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $guest = new Guest();
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($guest);
            $entityManager->flush();

            return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guest/new.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }

    #[Route('/{_locale}/{id}', name: 'app_guest_show', locale: 'en', methods: ['GET'])]
    public function show(Guest $guest): Response
    {
        return $this->render('guest/show.html.twig', [
            'guest' => $guest,
        ]);
    }

    #[Route('/{_locale}/{id}/edit', name: 'app_guest_edit', locale: 'en', methods: ['GET', 'POST'])]
    public function edit(Request $request, Guest $guest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GuestType::class, $guest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('guest/edit.html.twig', [
            'guest' => $guest,
            'form' => $form,
        ]);
    }

    #[Route('/{_locale}/{id}', name: 'app_guest_delete', locale: 'en', methods: ['POST'])]
    public function delete(Request $request, Guest $guest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guest->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($guest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_guest_index', [], Response::HTTP_SEE_OTHER);
    }
}
