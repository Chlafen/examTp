<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $manager;
    public function __construct(private ManagerRegistry $doctrine, private EntrepriseRepository $repository)
    {
//        $this->repository = $doctrine->getRepository(Personne::class);
        $this->manager = $doctrine->getManager();
    }
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $entreprises = $this->repository->findAll();
        $counts = [];
        //get count of pfe for each entreprise
        foreach ($entreprises as $entreprise) {
            $count = $this->manager->createQuery('SELECT COUNT(p) FROM App\Entity\Pfe p WHERE p.entreprise = :entreprise')
                ->setParameter('entreprise', $entreprise)
                ->getSingleScalarResult();
            $counts[$entreprise->getId()] = $count;
        }
        return $this->render('home/index.html.twig', [
            'entreprises' => $entreprises,
            'counts' => $counts
        ]);
    }
}
