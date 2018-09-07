<?php

namespace RP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Serie
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RP\CoreBundle\Entity\SerieRepository")
 */
class Serie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsys", type="string", length=255)
     */
    private $synopsys;

    /**
     * @var string
     *
     * @ORM\Column(name="caracters", type="string", length=255)
     */
    private $caracters;

    /**
     * @var integer
     *
     * @ORM\Column(name="saisons", type="integer")
     */
    private $saisons;

    /**
     * @var integer
     *
     * @ORM\Column(name="episodes", type="integer")
     */
    private $episodes;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * @return Serie
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
     * Set description
     *
     * @param string $description
     * @return Serie
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
     * Set synosys
     *
     * @param string $synosys
     * @return Serie
     */
    public function setSynosys($synosys)
    {
        $this->synosys = $synosys;

        return $this;
    }

    /**
     * Get synosys
     *
     * @return string 
     */
    public function getSynosys()
    {
        return $this->synosys;
    }

    /**
     * Set caracters
     *
     * @param string $caracters
     * @return Serie
     */
    public function setCaracters($caracters)
    {
        $this->caracters = $caracters;

        return $this;
    }

    /**
     * Get caracters
     *
     * @return string 
     */
    public function getCaracters()
    {
        return $this->caracters;
    }

    /**
     * Set saisons
     *
     * @param integer $saisons
     * @return Serie
     */
    public function setSaisons($saisons)
    {
        $this->saisons = $saisons;

        return $this;
    }

    /**
     * Get saisons
     *
     * @return integer 
     */
    public function getSaisons()
    {
        return $this->saisons;
    }

    /**
     * Set episodes
     *
     * @param integer $episodes
     * @return Serie
     */
    public function setEpisodes($episodes)
    {
        $this->episodes = $episodes;

        return $this;
    }

    /**
     * Get episodes
     *
     * @return integer 
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Serie
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

    /**
     * Set image
     *
     * @param string $image
     * @return Serie
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set synopsys
     *
     * @param string $synopsys
     * @return Serie
     */
    public function setSynopsys($synopsys)
    {
        $this->synopsys = $synopsys;

        return $this;
    }

    /**
     * Get synopsys
     *
     * @return string 
     */
    public function getSynopsys()
    {
        return $this->synopsys;
    }
}
