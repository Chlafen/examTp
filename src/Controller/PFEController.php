<?php

namespace App\Controller;

use App\Entity\PFE;
use App\Form\PFEType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PFEController extends AbstractController
{
    private $manager;
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
    }

    #[Route('/pfe/{id?0}', name:'app_pfe')]
    public function index(PFE $pfe=null): Response
    {
//        if ($pfe === null) {
//            return $this->redirectToRoute();
//        }

        return $this->render('pfe/index.html.twig', [
            'pfe' => $pfe,
        ]);
    }

    #[Route('/pfe/form/{id?0}', name:'app_pfeform')]
    public function form(PFE $pfe=null)
    {
        $pfe = $pfe ? $pfe : new PFE();
        $form = $this->createForm(PFEType::class, $pfe);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($this->getRequest());

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($pfe);
            $this->manager->flush();
        }
        return $this->render('pfe/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
