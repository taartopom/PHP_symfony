<?php

namespace AppBundle\Command;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class AppAddArticleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:add-article')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // récupérer le helper (pour demander des informations à l'utilisateur)
        $helper = $this->getHelper('question');

        // demander une information à l'utilisateur
        $question = new Question('Saisissez le titre de l\'article ?');

        // récupérer ce que l'utilisateur a saisi
        do {
            $reponseDeLutilisateur = $helper->ask($input, $output, $question);
        } while ($reponseDeLutilisateur == null);

        $article = new Article();
        $article->setTitle($reponseDeLutilisateur);
        $article->setDescription("Description de l'article");
        $article->setIsOnline(true);

        /** associer l'article à un utilisateur **/
        // récupérer le manager doctrine
        $em = $this->getContainer()->get('doctrine')->getManager();

        // récupérer un utilisateur
        $user = $em->getRepository('AppBundle:User')->find(1);

        // associer l'utisatateur à l'article
        $article->setUser($user);

        /** associer l'article à une catégorie */
        // demander une information à l'utilisateur
        $question = new Question('Saisissez le ne nom de la nouvelle categorie');

        // récupérer ce que l'utilisateur a saisi
        do {
            $reponseDeLutilisateur = $helper->ask($input, $output, $question);
        } while ($reponseDeLutilisateur == null);

        $category = new Category();
        $category->setName($reponseDeLutilisateur);

        // associer la categorie à l'article
        $article->setCategory($category);

        /** Associer des tags à l'article **/
        // créer des tags
        $tag = new Tag();
        $tag->setName("Prout");

        $tag2 = new Tag();
        $tag2->setName("prout2");

        // associer les tags
        $article->addTag($tag);
        $article->addTag($tag2);

        $em->persist($article);
        $em->persist($category);
        $em->persist($tag);
        $em->persist($tag2);

        $em->flush();
    }

}
