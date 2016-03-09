<?php

namespace BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="BilletterieBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", unique=true)
     */
    private $idCommande;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_billets", type="integer")
     */
    private $nbBillets;
    
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_visite", type="date")
     */
    private $dateVisite;

    /**
     * @var int
     *
     * @ORM\Column(name="journee_entiere", type="boolean", nullable=true)
     */
    private $journeeEntiere;
        
    /**
     * @var string
     *
     * @ORM\Column(name="ip_client", type="string", length=16)
     */
    private $ipClient;


    public function __construct()
    {
      $this->dateVisite   = new \Datetime(); /* date du jour par défaut */
      $this->journeeEntiere   = true; /* billet journée par défaut */
      $this->beneficiaires = new ArrayCollection();
    }
  
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCommande
     *
     * @param integer $idCommande
     *
     * @return Commande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    /**
     * Get idCommande
     *
     * @return int
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    public function setNbBillets($nbBillets)
    {
        $this->nbBillets = $nbBillets;

        return $this;
    }    
    public function getNbBillets()
    {
        return $this->nbBillets;
    }

    /**
     * Set dateVisite
     *
     * @param \Date $dateVisite
     *
     * @return \Date
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }

    /**
     * Set journeeEntiere
     *
     * @param boolean $journeeEntiere
     *
     * @return Commande
     */
    public function setJourneeEntiere($journeeEntiere)
    {
        $this->journeeEntiere = $journeeEntiere;

        return $this;
    }

    /**
     * Get journeeEntiere
     *
     * @return boolean
     */
    public function getJourneeEntiere()
    {
        return $this->journeeEntiere;
    }
    
    /**
     * Set ipClient
     *
     * @param string $ipClient
     *
     * @return Commande
     */
    public function setIpClient($ipClient)
    {
        $this->ipClient = $ipClient;

        return $this;
    }

    /**
     * Get ipClient
     *
     * @return string
     */
    public function getIpClient()
    {
        return $this->ipClient;
    }
    
    public function getName()
    {
      return 'billetterie_bundle_commandetype';
    }
}

