<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends Controller
{
    /**
     * @Route("/service", name="service")
     */
    public function serviceAction() {
        $serviceDoctrine = $this->get('doctrine');
        $serviceFormFactory = $this->get('form.factory');

        /*
         * on déclarer la classe Util comme un service
         * et du coup plus besoin d'instanciation
         *
         * 1- créer la classe
         * 2- la déclarer comme service dans le fichier
         * app/config/services.yml
         *
         */

        /*
         * Utilisation avant le service :
        $util = new Util();
        $var = $util->getUniqCode();
        */

        // maintenant que la classe Util est déclarée comme service
        $var = $this->get('app.util')->getUniqCode();

        $titreArticle = "Bievenue ! C'est évidemment cool ce titre !";
        $slug = $this->get('app.util')->slugify($titreArticle);
        $article = $this->get('app.util')->getArticleById(3);

        return new Response($article->getTitle());
    }

}
