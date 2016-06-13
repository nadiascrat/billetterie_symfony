<?php

namespace BilletterieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="billet")
 * @ORM\Entity(repositoryClass="BilletterieBundle\Repository\BilletRepository")
 
 */
class Billet
{
  
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
  
  /**
   * @ORM\ManyToOne(targetEntity="BilletterieBundle\Entity\Commande", inversedBy="billets", cascade={"persist", "merge"})
   * @ORM\JoinColumn(nullable=false)
   */
  protected $commande;

  /**
   * @ORM\Column(name="nom", type="string", length=255)
   */
  private $nom;
  
  /**
   * @ORM\Column(name="prenom", type="string", length=255)
   */
  private $prenom;

  /**
   * @ORM\Column(name="nationalite", type="string", length=255)
   */
  private $nationalite;

  /**
   * @ORM\Column(name="date_naissance", type="datetime")
   */
  private $dateNaissance;
  
  /**
   * @ORM\Column(name="tarif_special", type="boolean")
   */
  private $tarifSpecial;
  
  public function __construct()
  {
    $this->nationalite = "France";
  }
  
  public function getId()
  {
    return $this->id;
  }

  public function setNom($nom)
  {
    $this->nom = $nom;
    return $this;
  }

  public function getNom()
  {
    return $this->nom;
  }

  public function setPrenom($prenom)
  {
    $this->prenom = $prenom;
    return $this;
  }

  public function getPrenom()
  {
    return $this->prenom;
  }

  public function setNationalite($nationalite)
  {
    $this->nationalite = $nationalite;
    return $this;
  }

  public function getNationalite()
  {
    return $this->nationalite;
  }
    
  public function setDateNaissance($dateNaissance)
  {
    $this->dateNaissance = $dateNaissance;

    return $this;
  }

  public function getdateNaissance()
  {
    return $this->dateNaissance;
  }
      
  public function setTarifSpecial($tarifSpecial)
  {
    $this->tarifSpecial = $tarifSpecial;

    return $this;
  }

  public function getTarifSpecial()
  {
    return $this->tarifSpecial;
  }

    /**
     * Set commande
     *
     * @param \BilletterieBundle\Entity\Commande $commande
     *
     * @return Billet
     */
    public function setCommande(\BilletterieBundle\Entity\Commande $commande)
    {
        $this->commande = $commande;
        return $this;
    }

    /**
     * Get commande
     *
     * @return \BilletterieBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
