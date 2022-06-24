<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="app_articles")
     */
    public function allArticles(ManagerRegistry $doctrine): Response
    {
               $allArticles = $doctrine->getRepository(Article::class)->findAll();
            // dd($articles);
        return $this->render('article/allArticles.html.twig', [
            'controller_name' => 'ArticleController',
            'allArticles'=>$allArticles
        ]);
    }

        /**
     * @Route("/one-article/{id<\d+>}", name="one_article")
     */
    public function oneArticle($id, ManagerRegistry $doctrine): Response
    {
               $article = $doctrine->getRepository(Article::class)->find($id);
            return $this->render('article/oneArticle.html.twig', [
            'article'=>$article
            
        ]);
    }


  /**
     * @Route("/ajout-article", name="ajout_article")
     */

        public function ajout(ManagerRegistry $doctrine, Request $request)
    {
                // on crée un objet
               $article = new Article();
               // on crée le formulaire en liant FormType à l'objet crée
               $form =$this->createForm(ArticleType::class, $article);
               // on donne l'acces aux données du formulaire par la validations des données
               $form->handleRequest($request);
                // si le formulaire est soumis et valide
            if($form->isSubmitted() && $form->isValid()){
                // je m'occupe d'affecter les données manquantes (qui ne parviennent pas du formulaire)
                $article->setDateDeCreation( new DateTime("now"));
                // on récupère le manager de doctrine
                $manager=$doctrine->getManager();
                // on persiste l'objet
                $manager->persist($article);
                // et on l'envoie en bdd
                $manager->flush();

                return $this->redirectToRoute("app_articles");
            }
            return $this->render('article/formulaire.html.twig', [
            'formArticle'=>$form->createView()
        ]);
    } 


      /**
     * @Route("/update-article/{id<\d+>}", name="update_article")
     */
        public function update(ManagerRegistry $doctrine, $id, Request $request)
    {
                // on va récupérer l'article avec l'id
                $article = $doctrine->getRepository(Article::class)->find($id);
               $form =$this->createForm(ArticleType::class, $article);
               $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                $article->setDateDeModification( new DateTime("now"));
                $manager=$doctrine->getManager();
                $manager->persist($article);
                $manager->flush();

                return $this->redirectToRoute("app_articles");
            }
            return $this->render('article/formulaire.html.twig', [
            'formArticle'=>$form->createView()
        ]);
    } 

      /**
     * @Route("/delete_article_{id<\d+>}", name="delete_article")
     */
        public function delete($id, ManagerRegistry $doctrine)
    {
                // on va récupérer l'article avec l'id
                $article = $doctrine->getRepository(Article::class)->find($id);
                $manager=$doctrine->getManager();
                $manager->remove($article);
                $manager->flush();
                return $this->redirectToRoute("app_articles");
    } 


}
