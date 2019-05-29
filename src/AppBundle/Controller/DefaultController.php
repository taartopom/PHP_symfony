<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/test", name="test_page")
     */
    public function testAction(Request $request)
    {
        $response = $this->render('default/test.html.twig');
        return  $response;
        /*
        return new Response("
            <!DOCTYPE html>
            <html>
                <head></head>
                <body>Coucou</body>
            </html>
        ");
        */
    }

    /**
     * @Route("/page-de-test", name="toto")
     */
    public function totoAction(Request $request)
    {
        return new Response("0");
    }

    /**
     * @Route("/page-de-test-avec-template", name="toto2")
     */
    public function toto2Action(Request $request)
    {
        $templateHtml = $this->renderView('default/page_test_template.html.twig');
        return new Response($templateHtml);
    }

    /**
     * @Route("/template-heritage", name="template_heritage")
     */
    public function templateHeritageAction(Request $request)
    {
        $templateHtml = $this->renderView('default/template_heritage.html.twig');
        return new Response($templateHtml);
    }

    /**
     * @Route("/page-avec-variable", name="page_avec_variable")
     */
    public function pageAvecVariableAction(Request $request)
    {
        $i = 0;
        $i = $i + 15 * 2;

        // passer des variables à twig pour pouvoir
        // les utiliser dans le template : ici on a passé deux paramètres
        // i et cle2, qui auront pour valeur 30 et 50 dans le template
        $templateHtml = $this->renderView(
            'default/toto_variable.html.twig',
            ["i" => $i, 'cle2' => "50"]
        );
        return new Response($templateHtml);
    }

    /**
     * @Route("/tuto-form", name="tuto_form")
     */
    public function tutoFormAction(Request $request)
    {
        $templateHtml = $this->renderView('tuto/tuto-form.html.twig');
        return new Response($templateHtml);
    }
}
