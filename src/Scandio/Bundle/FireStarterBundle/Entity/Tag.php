<?php

namespace Scandio\Bundle\FireStarterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 */
class Tag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var Link
     */
    private $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Scandio\Bundle\FireStarterBundle\Entity\Link $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function setLink(Link $link)
    {
        $this->links->add($link);
    }

    /**
     * @return \Scandio\Bundle\FireStarterBundle\Entity\Link
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->slug = Link::slugify($name);
    
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
