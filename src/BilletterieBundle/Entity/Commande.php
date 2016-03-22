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
     * @var string
     *
     * @ORM\Column(name="ip_client", type="string", length=16)
     */
    private $ipClient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=30)
     */
    private $nomClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom_client", type="string", length=30)
     */
    private $prenomClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse_client", type="string", length=100)
     */
    private $adresseClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse2_client", type="string", length=100)
     */
    private $adresse2Client;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cp_client", type="integer", length=5)
     */
    private $cpClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_client", type="string", length=50)
     */
    private $villeClient;

    /**
     * @ORM\OneToMany(targetEntity="BilletterieBundle\Entity\Billet", mappedBy="commande", cascade={"persist"})
     */
    protected $billets;
  
  
    public function __construct()
    {
      $this->ipClient = $_SERVER['REMOTE_ADDR']; 
      $this->dateVisite   = new \Datetime(); /* date du jour par défaut */
      $this->journeeEntiere   = true; /* billet journée par défaut */
      $this->billets = new ArrayCollection();
    }

    // Notez le singulier, on ajoute un seul billet à la fois
    public function addBillet(Billet $billet)
    {
      // Ici, on utilise l'ArrayCollection vraiment comme un tableau
      $this->billets[] = $billet;  
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
    
    public function setNomClient($nomClient)
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getNomClient()
    {
        return $this->nomClient;
    }
    
    public function setPrenomClient($prenomClient)
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getPrenomClient()
    {
        return $this->prenomClient;
    }
    
    public function setAdresseClient($adresseClient)
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getAdresseClient()
    {
        return $this->adresseClient;
    }
    
    public function setAdresse2Client($adresse2Client)
    {
        $this->adresse2Client = $adresse2Client;

        return $this;
    }

    public function getAdresse2Client()
    {
        return $this->adresse2Client;
    }
    
    public function setCpClient($cpClient)
    {
        $this->cpClient = $cpClient;

        return $this;
    }

    public function getCpClient()
    {
        return $this->cpClient;
    }
    
    public function setVilleClient($villeClient)
    {
        $this->villeClient = $villeClient;

        return $this;
    }

    public function getVilleClient()
    {
        return $this->villeClient;
    }
    
    public function getName()
    {
      return 'billetterie_bundle_commandetype';
    }
    

}

