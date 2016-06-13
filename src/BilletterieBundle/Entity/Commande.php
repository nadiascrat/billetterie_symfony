<?php

namespace BilletterieBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

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
     * @var \Datetime
     *
     * @ORM\Column(name="date_visite", type="date")
     * @Assert\DateTime()     
     */
    private $dateVisite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="journee_entiere", type="boolean", nullable=true)
     * @Assert\NotBlank()     
     */
    private $journeeEntiere;
        

    /**
     * @ORM\OneToMany(targetEntity="BilletterieBundle\Entity\Billet", mappedBy="commande", cascade={"persist"})
     */
    protected $billets;
    
    /**
     * @ORM\OneToOne(targetEntity="BilletterieBundle\Entity\Paiement", cascade={"persist"})
     */
    protected $paiement;
  
  
    public function __construct()
    {
      $this->dateVisite   = new \Datetime(); /* date du jour par défaut */
      $this->journeeEntiere   = true; /* billet journée par défaut */
      $this->billets = new ArrayCollection();
    }

    // Notez le singulier, on ajoute un seul billet à la fois
    public function addBillet(Billet $billets)
    {
      // Ici, on utilise l'ArrayCollection vraiment comme un tableau
      $this->billets[] = $billets;
      $billets->setCommande($this);
      return $this;
    }
  
    public function removeBillet(Billet $billet)
    {
      // Ici on utilise une méthode de l'ArrayCollection, pour supprimer le billet en argument
      $this->billets->removeElement($billet);
    }
  
    // Notez le pluriel, on récupère une liste de billets ici !
    public function getBillets()
    {
      return $this->billets;
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
     * Set id
     *
     * @param integer $id
     *
     * @return Commande
     */
    public function setId($idCommande)
    {
        $this->id = $idCommande;
        return $this;
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
    
    
    public function setPaiement(Paiement $paiement = null)
    {
      $this->paiement = $paiement;
    }
  
    public function getPaiement()
    {
      return $this->paiement;
    }
    
    public function getName()
    {
      return 'billetterie_bundle_commandetype';
    }
    

}
