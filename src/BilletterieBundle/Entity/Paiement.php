<?php

namespace BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="BilletterieBundle\Repository\PaiementRepository")
 
 */
class Paiement
{
  
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
  
    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=30, nullable=true)
     */
    private $nomClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="prenom_client", type="string", length=30, nullable=true)
     */
    private $prenomClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse_client", type="string", length=100, nullable=true)
     */
    private $adresseClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="adresse2_client", type="string", length=100, nullable=true)
     */
    private $adresse2Client;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cp_client", type="integer", length=5, nullable=true)
     */
    private $cpClient;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville_client", type="string", length=50, nullable=true)
     */
    private $villeClient;
    
    public function __construct()
    {

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
}