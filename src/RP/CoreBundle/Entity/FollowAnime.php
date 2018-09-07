<?php

namespace RP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FollowAnime
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RP\CoreBundle\Entity\FollowAnimeRepository")
 */
class FollowAnime
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
     * @var integer
     *
     * @ORM\Column(name="saison", type="integer")
     */
    private $saison;

    /**
     * @var integer
     *
     * @ORM\Column(name="episode", type="integer")
     */
    private $episode;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;


    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="RP\CoreBundle\Entity\Anime")
     * @ORM\JoinColumn(nullable=false)
     */   
    private $anime;
  
    /**
     * @ORM\ManyToOne(targetEntity="RP\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
     private $user;


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
     * Set saison
     *
     * @param integer $saison
     * @return FollowAnime
     */
    public function setSaison($saison)
    {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return integer 
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set episode
     *
     * @param integer $episode
     * @return FollowAnime
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return integer 
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return FollowAnime
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return FollowAnime
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set anime
     *
     * @param \RP\CoreBundle\Entity\Anime $anime
     * @return FollowAnime
     */
    public function setAnime(\RP\CoreBundle\Entity\Anime $anime)
    {
        $this->anime = $anime;

        return $this;
    }

    /**
     * Get anime
     *
     * @return \RP\CoreBundle\Entity\Anime 
     */
    public function getAnime()
    {
        return $this->anime;
    }

    /**
     * Set user
     *
     * @param \RP\UserBundle\Entity\User $user
     * @return FollowAnime
     */
    public function setUser(\RP\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \RP\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return FollowAnime
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }
}
