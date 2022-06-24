<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        // on cherche le dernier article inséré dans la bdd en utilisant le répository de la class Article (ArticleRepository)
        $lastArticle = $doctrine->getRepository(Article::class)->findOneBy([], ["dateDeCreation" =>"DESC"]);

        // dump and die
        // dd($lastArticle);

        return $this->render('home/index.html.twig', [
            'lastArticle'=>$lastArticle
        ]);
    }
}
