<?php

namespace App\Controller;

use App\Entity\Ads;
use App\Repository\AdsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $manager, AdsRepository $repoEntity): Response
    {

        $repoEntity = $manager->getRepository(Ads::class);
        $bdd = $repoEntity->findAll();

        return $this->render('home/index.html.twig', [
            'cards' => $bdd
        ]);
    }
}
