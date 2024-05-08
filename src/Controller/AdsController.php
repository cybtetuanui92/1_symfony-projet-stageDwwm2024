<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Form\AdsType;
use App\Repository\AdsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/troc')]
class AdsController extends AbstractController
{

    // ! ICI la page PROFIL
    #[Route('/', name: 'app_ads_index', methods: ['GET'])]
    public function home(AdsRepository $adsRepository, UsersRepository $usersRep, EntityManagerInterface $entityManager): Response
    {   
        // Obtenir l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer les annonces créées par l'utilisateur
        // $ads = $entityManager->getRepository(Ads::class)->findBy(['username' => $user]);

        return $this->render('ads/index.html.twig', [
            'ads' => $adsRepository->findAll(),
            'users' => $user,
        ]);
    }

    // ! Logique du CREATE
    /**
     * @IsGranted("ROLE_USER")
     */
    #[Route('/new', name: 'app_ads_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ad = new Ads();
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer l'utilisateur à l'annonce et assigne l'utilisateur connecté comme auteur de l'annonce
            $ad->setUser($this->getUser());
            $entityManager->persist($ad);
            $entityManager->flush();

            $this->addFlash('success', 'Votre carte a bien été créée.');

            return $this->redirectToRoute('app_ads_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ads/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    // ! ICI logique du READ DÉTAILS
    #[Route('/{id}', name: 'app_ads_show', methods: ['GET'])]
    public function show(Ads $ad): Response
    {
        return $this->render('ads/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    // ! ICI logique du UPDATE
    #[Route('/{id}/edit', name: 'app_ads_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdsType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La carte a été modifiée avec succès.');

            return $this->redirectToRoute('app_ads_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ads/edit.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    // ! ICI logique du DELETE
    #[Route('/{id}/delete', name: 'app_ads_delete', methods: ['POST'])]
    public function delete(Request $request, Ads $ad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ad);
            $entityManager->flush();

            $this->addFlash('success', 'La carte a été supprimée avec succès.');
        }

        return $this->redirectToRoute('app_ads_index', [], Response::HTTP_SEE_OTHER);
    }
}
