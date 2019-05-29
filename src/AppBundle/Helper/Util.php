<?php


namespace AppBundle\Helper;


class Util
{
    private $doctrine;
    private $formFactory;

    public function __construct($paramServiceDoctrine, $serviceFaormFacotry)
    {
        $this->doctrine = $paramServiceDoctrine;
        $this->formFactory = $serviceFaormFacotry;
    }

    public function getUniqCode() {
        // générer une valeur unique
        $randomValue = md5(uniqid(rand(), true));

        // puis renvoyer cette valeur
        return $randomValue;
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function getArticleById($id) {
        // this->doctrine est récupéré dans le controller de Util grâce à l'injection
        // du service doctrine dans le fichier de config : app/config/services.yml
       $em = $this->doctrine->getManager();
       $article = $em->getRepository('AppBundle:Article')->find($id);

       return $article;
    }
}