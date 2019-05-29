<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExoController extends Controller
{
    /*
     * Créer trois pages : routes, controller, et templates
     * Chaque template doit hériter du template base.html.twig
     * Et dans le body de chaque page, vous mettez :
     * pour la page 1 : "Ceci est la page 1"
     * pour la page 2 : "Ceci est la page 2"
     * pour la page 3 : "Ceci est la page 3"
     * Et dans chaqe template : vous mettez les trois liens qui pointent
     * vers chacune des pages
     * Dans la page 3, le controller doit faire une multiplication
     * et passer au template le résultat de cette multiplication pour l'afficher
     */

    /**
     * @Route("/page-1", name="premiere_page")
     */
    public function page1Action(Request $request)
    {
        $templateHtml = $this->render('exo/page1.html.twig');
        return $templateHtml;
    }

    /**
     * @Route("/page-2", name="deuxieme_page")
     */
    public function page2Action(Request $request)
    {
        $templateHtml = $this->render('exo/page2.html.twig');
        return $templateHtml;
    }

    /**
     * @Route("/page-3", name="trosieme_page")
     */
    public function page3Action(Request $request)
    {
        $resultat = 150 * 12.53;
        $templateHtml = $this->render('exo/page3.html.twig', [
            'resultat' => $resultat
        ]);
        return $templateHtml;
    }

    /**
     * @Route("/page-4/{annee}/{mois}/{jour}",
     *     name="quatrieme_page",
     *     requirements={"annee"="\d{4}", "mois"="\d{2}"},
     *     defaults={"jour"="01"}
     *     )
     */
    public function page4Action(Request $request)
    {

        return new Response(0);
    }
}
