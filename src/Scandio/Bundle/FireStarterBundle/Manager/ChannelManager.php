<?php
namespace Scandio\Bundle\FireStarterBundle\Manager;

use Doctrine\ORM\EntityManager;
use Scandio\Bundle\FireStarterBundle\Entity\ChannelRepository;

class ChannelManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var ChannelRepository
     */
    private $channelRepository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->channelRepository = $em->getRepository('Scandio\Bundle\FireStarterBundle\Entity\Channel');
    }

    /**
     * @return array
     */
    public function getChannels()
    {
        return $this->channelRepository->findBy([], ['name' => 'ASC']);
    }
}