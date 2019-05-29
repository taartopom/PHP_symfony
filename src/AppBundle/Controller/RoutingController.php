<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutingController extends Controller
{
    /* En format yml, les routes sont définies dans un fichier à part :
        routing.yml qui se trouve dans app/config/
    */
    public function routing1Action(Request $request)
    {
        $templateHtml = $this->render('routing/routing1.html.twig');
        return $templateHtml;
    }

    public function routing2Action(Request $request)
    {
        $templateHtml = $this->render('routing/routing2.html.twig');
        return $templateHtml;
    }

    public function routing3Action(Request $request, $id)
    {
        // par exemple on peut aller en BDD le user qui a l'ID = $id

        $templateHtml = $this->render('routing/routing3.html.twig', [
            'id' => $id
        ]);
        return $templateHtml;
    }

    public function routing4Action(Request $request, $annee, $mois, $jour)
    {
        // par exemple on peut aller en BDD le user qui a l'ID = $id

        $templateHtml = $this->render('routing/routing4.html.twig', [
            'annee' => $annee,
            'mois' => $mois,
            'jour' => $jour
        ]);
        return $templateHtml;
    }

    public function routing5Action(Request $request)
    {
        /* passer un tableau du controller à la vue */
        $tableauNumerique = ['toto', 'salut', 'ordinateur'];
        $tableauAssociatif = ['cle1' => 10, 'zipcode' => '59000'];

        /* on affiche rien dans le controller */
        /*
         * NON ON FAIT PAS CA :
        foreach ($tableauNumerique as $value) {
            echo $value;
        }
        */

        $templateHtml = $this->render('routing/routing5.html.twig', [
            'tableauNumerique' => $tableauNumerique,
            'tableauAssociatif' => $tableauAssociatif
        ]);
        return $templateHtml;
    }
}
