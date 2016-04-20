<?php

namespace NTR1X\LayoutBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Source
 *
 * @ORM\Table(name="source_items")
 * @ORM\Entity
 */
class Source
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
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="schemes")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", nullable=false)
     */
    private $page;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="url", type="string", length=511)
	 */
	private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="method", type="string", length=511)
     */
    private $method;

    /**
     * @ORM\Column(name="params", type="json_array", nullable=true)
     */
    private $params;

	public function __construct() {
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
     * @return Source
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
     * Set path
     *
     * @param string $path
     *
     * @return Source
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Source
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set params
     *
     * @param array $params
     *
     * @return Source
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set schema
     *
     * @param \NTR1X\LayoutBundle\Entity\Schema $schema
     *
     * @return Source
     */
    public function setSchema(\NTR1X\LayoutBundle\Entity\Schema $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Get schema
     *
     * @return \NTR1X\LayoutBundle\Entity\Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Set page
     *
     * @param \NTR1X\LayoutBundle\Entity\Page $page
     *
     * @return Source
     */
    public function setPage(\NTR1X\LayoutBundle\Entity\Page $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \NTR1X\LayoutBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Source
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
