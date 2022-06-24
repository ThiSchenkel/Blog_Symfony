<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    /**
     * @Route("/ajout-auteur", name="ajout_auteur")
     */
    public function ajout(ManagerRegistry $doctrine, Request $request) : Response
    {
        $auteur = new Auteur();
        $form=$this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager=$doctrine->getManager();
            $manager->persist($auteur);
            $manager->flush();

            return $this->redirectToRoute("app_auteurs");
        }
        return $this->render('auteur/formAuteur.html.twig', [
            'formAuteur'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/auteurs", name="app_auteur")
     */
    public function allAuteurs(ManagerRegistry $doctrine, Request $request) : Response
    {
        $allAuteurs=$doctrine->getRepository(Auteur::class)->findAll();
        return $this->render('auteur/allAuteurs.html.twig', [
            'allAuteurs'=>$allAuteurs
        ]);
    }

    /**
     * @Route("/auteur/{id<\d+>}", name="auteur")
     */
    public function oneAuteur($id, ManagerRegistry $doctrine) : Response
    {
        $auteur=$doctrine->getRepository(Auteur::class)->find($id);
        return $this->render('auteur/oneAuteur.html.twig', [
            'auteur'=>$auteur
        ]);
    }

    /**
     * @Route("/update-auteur/{id<\d+>}", name="update_auteur")
     */
    public function update(ManagerRegistry $doctrine, $id, Request $request) : Response
    {
        $auteur = $doctrine->getRepository(Auteur::class)->find($id);
        $form =$this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
        $manager=$doctrine->getManager();
        $manager->persist($auteur);
        $manager->flush();

                return $this->redirectToRoute("app_auteurs");
        }
        return $this->render('auteur/formAuteur.html.twig', [
            'formAuteur'=>$form->createView(),
        ]);
    }

        /**
     * @Route("/delete-auteur/{id}", name="delete_auteur")
     */
    public function delete($id, ManagerRegistry $doctrine){
        $auteur=$doctrine->getRepository(Auteur::class)->find($id);
        $manager=$doctrine->getManager();
        $manager->remove($auteur);
        $manager->flush();
        return $this->redirectToRoute('app_auteur');
    }





















}
