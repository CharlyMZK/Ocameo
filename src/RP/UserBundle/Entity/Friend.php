<?php

namespace RP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friend
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RP\UserBundle\Entity\FriendRepository")
 */
class Friend
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
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="RP\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $holder;


    /**
     * @ORM\ManyToOne(targetEntity="RP\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;


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
     * Set statut
     *
     * @param string $statut
     * @return Friend
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;
    
        return $this;
    }

    /**
     * Get statut
     *
     * @return string 
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Friend
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
     * Set holder
     *
     * @param \RP\UserBundle\Entity\User $holder
     * @return Friend
     */
    public function setHolder(\RP\UserBundle\Entity\User $holder)
    {
        $this->holder = $holder;
    
        return $this;
    }

    /**
     * Get holder
     *
     * @return \RP\UserBundle\Entity\User 
     */
    public function getHolder()
    {
        return $this->holder;
    }

    /**
     * Set target
     *
     * @param \RP\UserBundle\Entity\User $target
     * @return Friend
     */
    public function setTarget(\RP\UserBundle\Entity\User $target)
    {
        $this->target = $target;
    
        return $this;
    }

    /**
     * Get target
     *
     * @return \RP\UserBundle\Entity\User 
     */
    public function getTarget()
    {
        return $this->target;
    }
}
