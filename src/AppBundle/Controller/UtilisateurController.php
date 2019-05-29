<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Utilisateur;

class UtilisateurController extends Controller
{
    /**
     * @Route("/utilisateur/view/{id}", name="utilisateur_view")
     */
    public function viewAction() {

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository("AppBundle:Utilisateur")->find(1);

        if ($utilisateur == null) {
            throw new NotFoundHttpException();
        }

        $response = $this->render('utilisateur/view.html.twig', [
            'utilisateur' => $utilisateur
        ]);
        return $response;
    }

    /**
     * @Route("/utilisateur/view/{id}", name="utilisateur_view_url")
     */
    public function viewUrlAction($id) {

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository("AppBundle:Utilisateur")->find($id);

        if ($utilisateur == null) {
            throw new NotFoundHttpException();
        }

        $response = $this->render('utilisateur/view.html.twig', [
            'utilisateur' => $utilisateur
        ]);
        return $response;
    }

    /**
     * @Route("/utilisateur/insert", name="utilisateur_insert")
     */
    public function insertAction() {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail("yosh@gmail.com");
        $utilisateur->setDateNaissance(new \DateTime("1990-08-21"));
        $utilisateur->setPassword("mdp123456");

        $em = $this->getDoctrine()->getManager();

        $userExist =$em->getRepository("AppBundle:Utilisateur")->findOneBy(['email'=>$email]);

        if($userExist == null){
            $em->persist($utilisateur);

            $em->flush();

            return new Response("Utilisateur bien enregistré id : ".$utilisateur->getId());

        }
        else{
            return new Response($email."est déjà utilisé");
        }
    }

    /**
     * @Route("/utilisateur/view-all", name="utilisateur_view_all")
     */
    public function viewAllAction($id) {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('AppBundle:Utilisateur')->findAll();
        $articlesOnline = $em->getRepository('AppBundle:Utilisateur')->findBy([
            'isOnline' => true
        ]);

        $response = $this->render('utilisateur/view_all.html.twig', [
            'utilisateurs' => $utilisateurs,
            'articlesOnline' => $articlesOnline
        ]);
        return $response;
    }

    /**
     * @Route("/update/{id}", name="utilisateur_update")
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository("AppBundle:Utilisateur")->find($id);

        $utilisateur->setPassword("Nouveau mots de passe");

        $em->persist($utilisateur);
        $em->flush();

        return new Response("mots de passe bien modifié");
    }

    /**
     * @Route("/remove/{id}", name="utilisateur_remove")
     */
    public function removeAction($id) {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository("AppBundle:Utilisateur")->find($id);

        // supprimer une entité
        if ($utilisateur != null) {
            $em->remove($utilisateur);
            $em->flush();
        }


        return new Response("Utilisateur bien supprimé");
    }

}
