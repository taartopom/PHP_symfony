<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Exo2Controller extends Controller
{
    /*
        Inclure ce controller dans le fichier de routing pour que les routes
        en annotation soient chargées
        Créer une page dont l'URL est /multiplication/{chiffre}
        L'url est dynamique et le paramètre chiffre doit être récupéré dans le controller
        Vous devez ensuite créer la table de multiplication de ce chiffre dans un tableau PHP
        Vous devez afficher cette table dans un tableau html dans un nouveau template
        le chiffre 5
        0 * 5 = 0
        1 * 5 = 5
        2 * 5 = 10
        Rajouter un h1 : Table de multiplication de "chiffre"
     */

    /**
     * @Route("/multiplication/{chiffre}", name="page_multiplication")
     */
    public function  multiAction(Request $request)
    {
        // faire les calculs et mettre dans un tableau
        $tableMultiplication = [];

        // passer ce tableau au template
        $templateHtml = $this->render('', [

        ]);
        return $templateHtml;
    }

}
