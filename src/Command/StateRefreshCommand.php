<?php

namespace App\Command;

use App\Entity\Etat;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StateRefreshCommand extends Command
{
    protected static $defaultName = 'StateRefreshCommand';
    protected static $defaultDescription = "Actualise les états des sorties en fonction de l'heure du serveur";

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     *
     */
    protected function execute(InputInterface $input,OutputInterface $output): void
    {
//        $sorties = $sortieRepository->findAll();
//        foreach ($sorties as $sortie){
//            $etatSortie = $sortie->getEtat()->getLibelle();
//            $datetimeNow = new \DateTime();
//            if ($etatSortie != 'Créée' or $etatSortie != 'Annulée' or $etatSortie != 'Passée')
//            {
//                if ($etatSortie == 'Ouverte'){
//                    if ($sortie->getDateLimiteInscription() > $datetimeNow){
//                        $etatSortie = $this->getDoctrine()->getRepository(Etat::class)->findOneBy(['libelle' => 'Ouverte']);
//                        $sortie->setEtat($etatSortie);
//                    }
//
//                }elseif ($etatSortie == 'Cloturée'){
//
//                }elseif ($etatSortie == 'Activité en cours'){
//
//                }
//            }
//        }


//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

    }
}
