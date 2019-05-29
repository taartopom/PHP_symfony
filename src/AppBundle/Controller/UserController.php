<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @Route("/user/insert", name="user_insert")
     */
    public function insertAction() {
        $email = "fab3@mail.fr";

        // 1- créer une instance de User
        $user = new User();
        $user->setEmail($email);
        $user->setDateNaissance(new \DateTime("1995-12-31"));
        $user->setPassword("pass123");

        // 2- récupérer le manager d'entité de doctrine
        $em = $this->getDoctrine()->getManager();

        // 3- vérifiez que l'email n'existe pas déjà en base
        $userExist = $em->getRepository('AppBundle:User')
                        ->findOneBy(['email' => $email]);

        if ($userExist == null) {
            // 4- enregistrer en base
            $em->persist($user);
            $em->flush();
            return new Response("User bien enregistré ".$user->getId());
        }
        else {
            return new Response($email. " est déjà existant");
        }
    }

    /**
     * @Route("/user/insert-form", name="user_insert_form")
     */
    public function insertFormAction(Request $request) {
        // 1- créer une instance de User
        $user = new User();

        // 2- récupérer le service form factory : création de formulaire
        $formFactory  = $this->get('form.factory');
        $formBuilder = $formFactory->createBuilder(FormType::class, $user);

        // 2-ou en une ligne
        $formBuilder = $this->get('form.factory')->createBuilder(
           UserType::class, $user
        );

        // 3-on ajoute les champs dans le formulaire
        // on ne fait plus cette config ici, car on a externalisé
        // dans la classe Form/UserType.php
        /*
        $formBuilder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('dateNaissance', DateType::class)
            ->add('valider', SubmitType::class)
        ;
        */

        // 4-à partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // récupérer les données envoyées pour hydrater l'objet
        $form->handleRequest($request);

        // si le formulaire a été soumis, alors enregistrer l'objet user
        // dont les propriétés ont été automatiquement settées
        // par le composant formulaire
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/insert.html.twig', [
            'formUser' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function editAction(Request $request, $id) {
        // récupérer le user à modifier
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->find($id);

        // créer un builder de formulaire associé à ce user
        $formBuilder = $this->get('form.factory')->createBuilder(
            UserType::class, $user
        );

        // à partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // récupérer les données envoyées pour hydrater l'objet
        $form->handleRequest($request);

        // si le formulaire a été soumis, alors enregistrer l'objet user
        // dont les propriétés ont été automatiquement settées
        // par le composant formulaire
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('user/insert.html.twig', [
            'formUser' => $form->createView(),
            'user' => $user
        ]);
    }
    /**
     * @Route("/user/view/{id}", name="user_view")
     */
    public function viewAction($id) {
        // 1- récupérer le manager
        $em = $this->getDoctrine()->getManager();

        // 2- récupérer un entristrement en base pour l'utiliser en objet
        $user = $em->getRepository('AppBundle:User')->find($id);

        // 3- passer cette entité à un template pour l'afficher
        $response = $this->render('user/view.html.twig', [
            'user' => $user
        ]);

        return $response;
    }

    /**
     * @Route("/user/remove/{id}", name="user_remove")
     */
    public function removeAction($id) {
        // 1- récupérer le manager
        $em = $this->getDoctrine()->getManager();

        // 2- récupérer un entristrement en base pour l'utiliser en objet
        $user = $em->getRepository('AppBundle:User')->find($id);

        // 3- dire à doctrine de supprimer cette entité
        $em->remove($user);
        $em->flush();

        return new Response("User bien supprimé");
    }

}
