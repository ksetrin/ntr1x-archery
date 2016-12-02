<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation as JMS;

/**
 * Page
 *
 * @ORM\Table(name="page_items")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PageRepository")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=511)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=511)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Portal")
     * @ORM\JoinColumn(name="portal_id", referencedColumnName="id", nullable=false)
     * @JMS\Exclude
     */
    private $portal;

    /**
     * @ORM\OneToOne(targetEntity="Widget", mappedBy="page", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $root;

    /**
     * @ORM\OneToMany(targetEntity="Source", mappedBy="page", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $sources;

    /**
     * @ORM\OneToMany(targetEntity="Storage", mappedBy="page", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $storages;

    public function __construct() {
        $this->sources = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    /**
     * Set portal
     *
     * @param \AppBundle\Entity\Portal $portal
     *
     * @return Page
     */
    public function setPortal(\AppBundle\Entity\Portal $portal)
    {
        $this->portal = $portal;

        return $this;
    }

    /**
     * Get portal
     *
     * @return \AppBundle\Entity\Portal
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Add source
     *
     * @param \AppBundle\Entity\Source $source
     *
     * @return Page
     */
    public function addSource(\AppBundle\Entity\Source $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * Remove source
     *
     * @param \AppBundle\Entity\Source $source
     */
    public function removeSource(\AppBundle\Entity\Source $source)
    {
        $this->sources->removeElement($source);
    }

    /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add storage
     *
     * @param \AppBundle\Entity\Storage $storage
     *
     * @return Page
     */
    public function addStorage(\AppBundle\Entity\Storage $storage)
    {
        $this->storages[] = $storage;

        return $this;
    }

    /**
     * Remove storage
     *
     * @param \AppBundle\Entity\Storage $storage
     */
    public function removeStorage(\AppBundle\Entity\Storage $storage)
    {
        $this->storages->removeElement($storage);
    }

    /**
     * Get storages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStorages()
    {
        return $this->storages;
    }

    /**
     * Get root
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set root
     *
     * @param \AppBundle\Entity\Widget $root
     *
     * @return Page
     */
    public function setRoot(\AppBundle\Entity\Widget $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Page
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}