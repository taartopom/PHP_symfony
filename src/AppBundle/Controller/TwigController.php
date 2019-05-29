<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends Controller
{
    /**
     * @Route("/filters", name="twig_filters")
     */
    public function twigFilterAction(Request $request)
    {
        $texte = "Bonjour tout le monde
                    Comment ça va ?
                    Moi cool !";

        $dateTime = new \DateTime();
        // ajouter 10 jours à la date
        $dateTime->add(new \DateInterval('P10D'));

        $html = "<p>Je suis un paragraphe</p><p>Et moi le deuxième paragraphe</p>";

        $entier = 10;
        $entier2 = 20;

        $templateHtml = $this->render('twig/template_twig_filters.html.twig', [
            'texte' => $texte,
            'dateTime' => $dateTime,
            'htmlParagraphe' => $html,
            'entier' => $entier,
            'entier2' => $entier2
        ]);
        return $templateHtml;
    }
}
