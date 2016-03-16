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
}