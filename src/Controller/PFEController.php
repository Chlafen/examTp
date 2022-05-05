<?php

namespace App\Controller;

use App\Entity\PFE;
use App\Form\PFEType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request ;

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

    #[Route('/pfeform/{id?0}', name:'app_pfe.form')]
    public function form(Request $request, PFE $pfe=null): Response
    {
        $pfe = $pfe ? $pfe : new PFE();
        $form = $this->createForm(PFEType::class, $pfe);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($pfe);
            $this->manager->flush();
            return $this->redirectToRoute('app_pfe', ['id' => $pfe->getId()]);
        }
        return $this->render('pfe/form.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
