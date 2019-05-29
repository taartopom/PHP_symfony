<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Article;

class ArticleController extends Controller
{
    /**
     * @Route("/article/view", name="article_view")
     */
    public function viewAction() {
        /*
        $article = new Article();
        $article->setTitle("Titre de l'article 1");
        $article->setDescription("Ici c'est la description de le produit");
        $article->setIsOnline(true);
        $article->setCreatedAt(new \DateTime());
        */

        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find(21);
        $em = $this->getDoctrine()->getManager();
        // générer une page d'erreur 404 si l'article n'existe pas
        if ($article == null) {
            // le code s'arrêtera ici si on rentre dans le if
            throw new NotFoundHttpException();
        }

        $response = $this->render('article/view.html.twig', [
            'article' => $article
        ]);
        return $response;
    }

    /**
     * @Route("/view/{id}", name="article_view_url")
     */
    public function viewUrlAction($id) {
        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($id);

        /*
         * Chercher un article en fonction de critères
         * on peut rechercher sur les propriétés de l'entité Article
         * (title, description, isOnline, createdAt)
         */
        /*
        $article = $em->getRepository("AppBundle:Article")->findOneBy([
            'title' => 'Article titre'
        ]);
        */

        // générer une page d'erreur 404 si l'article n'existe pas
        if ($article == null) {
            // le code s'arrêtera ici si on rentre dans le if
            throw new NotFoundHttpException();
        }

        $response = $this->render('article/view.html.twig', [
            'article' => $article
        ]);
        return $response;
    }

    /**
     * @Route("/insert", name="article_insert")
     */
    public function insertAction() {
        $article = new Article();
        $article->setTitle("Titre de l'article 2");
        $article->setDescription("Ici c'est la description 2");
        $article->setIsOnline(true);
        $article->setCreatedAt(new \DateTime());

        // récupérer le manager de doctrine pour insérer en bdd
        $em = $this->getDoctrine()->getManager();
        // persist sert à dire à doctrine de gérer cet objet
        $em->persist($article);
        // flush sert à envoyer réellement les requêtes à la bdd
        $em->flush();

        return new Response("Article bien enregistré id : ".$article->getId());
    }

    /**
     * @Route("/view-all", name="article_view_all")
     */
    public function viewAllAction() {
        // récupérer le manager de doctrine pour récupérer les articles en bdd
        $em = $this->getDoctrine()->getManager();
        // on récupère le repository correspond, ici on veut les articles en bdd
        // et la méthode findAll renvoie tous ces articles
        $articles = $em->getRepository('AppBundle:Article')->findAll();
        $articlesOnline = $em->getRepository('AppBundle:Article')->findBy([
            'isOnline' => true
        ]);

        $response = $this->render('article/view_all.html.twig', [
            'articles' => $articles,
            'articlesOnline' => $articlesOnline
        ]);
        return $response;
    }

    /**
     * @Route("/update/{id}", name="article_update")
     */
    public function updateAction($id) {
        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($id);

        $article->setTitle("Nouveau titre");

        $em->persist($article);
        $em->flush();

        return new Response("Article bien modifié");
    }

    /**
     * @Route("/remove/{id}", name="article_remove")
     */
    public function removeAction($id) {
        // récupérer un seul article depuis la base de données
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($id);

        // supprimer une entité
        if ($article != null) {
            $em->remove($article);
            $em->flush();
        }


        return new Response("Article bien supprimé");
    }

}
