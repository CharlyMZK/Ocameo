<?php

namespace RP\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RP\ArticleBundle\Entity\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;


    /**
     * @var string
     *
     * @ORM\Column(name="entete", type="string", length=255)
     */
    private $entete;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */     
    private $image;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="datetime", length=255)
     */      
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="RP\CoreBundle\Entity\Serie")
     * @ORM\JoinColumn(nullable=true)
     */   
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity="RP\CoreBundle\Entity\Film")
     * @ORM\JoinColumn(nullable=true)
     */   
    private $film;

    /**
     * @ORM\ManyToOne(targetEntity="RP\CoreBundle\Entity\Anime")
     * @ORM\JoinColumn(nullable=true)
     */   
    private $anime;


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
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }


    /**
     * Set entete
     *
     * @param string $entete
     * @return Article
     */
    public function setEntete($entete)
    {
        $this->entete = $entete;

        return $this;
    }

    /**
     * Get entete
     *
     * @return string 
     */
    public function getEntete()
    {
        return $this->entete;
    }


    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }


    /**
     * Set image
     *
     * @param string $image
     * @return Article
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
     * Set date
     *
     * @param datetime $date
     * @return Date
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

}
