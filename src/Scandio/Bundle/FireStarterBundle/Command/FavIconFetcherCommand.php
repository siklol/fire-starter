<?php
namespace Scandio\Bundle\FireStarterBundle\Command;

use Scandio\Bundle\FireStarterBundle\Entity\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FavIconFetcherCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('scandio:fav-icon:fetcher')
            ->setDescription('Fetches all fav icons for all links')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $favIconFetcher = $this->getContainer()->get('fav_icon_fetcher');

        /** @var LinkRepository $linkRepository */
        $linkRepository = $em->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Link');
        $links = $linkRepository->findAll();
        foreach ($links as $link) {
            $output->writeln('URL: '.$link->getUrl());
            $link->setFavicon($favIconFetcher->getByGoogleService($link->getUrl()));

            $em->persist($link);
        }
        $em->flush();
    }
}