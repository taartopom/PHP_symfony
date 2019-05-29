<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppFindLessThan18Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:find-less-than-18')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        // récupérer le container de service
        $container = $this->getContainer();
        // récupérer le service doctrine
        $doctrine = $container->get('doctrine');
        // récupérer le manager
        $em = $doctrine->getManager();

        $users = $em->getRepository('AppBundle:User')->findLess18();

        $output->writeln('Nombre d\'utilisateur : '.count($users));

        foreach ($users as $user) {
            $output->writeln($user->getEmail());
        }
    }

}
