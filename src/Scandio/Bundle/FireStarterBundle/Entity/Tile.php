<?php

namespace Scandio\Bundle\FireStarterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tile
 */
class Tile
{
    const TYPE_DEFAULT = 1;
    const TYPE_WIDGET = 2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var Link
     */
    private $links;

    /**
     * @var string
     */
    private $image;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var ArrayCollection
     */
    private $channels;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
        $this->position = 0;

        $this->links =  new ArrayCollection();
        $this->channels = new ArrayCollection();

        $this->type = self::TYPE_DEFAULT;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Scandio\Bundle\FireStarterBundle\Entity\Link $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return \Scandio\Bundle\FireStarterBundle\Entity\Link
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Tile
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param Channel $channel
     */
    public function addChannel(Channel $channel)
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tile
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Tile
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return Tile
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    
        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Tile
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $type
     * @return mixed
     */
    public function isType($type)
    {
        return defined('Scandio\\Bundle\\FireStarterBundle\\Entity\\Tile::TYPE_'.strtoupper($type));
    }
}
