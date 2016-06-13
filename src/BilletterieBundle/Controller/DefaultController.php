<?php

namespace BilletterieBundle\Controller;

use BilletterieBundle\Entity\Commande;
use BilletterieBundle\Form\CommandeType;
use BilletterieBundle\Entity\Billet;
use BilletterieBundle\Form\BilletType;
use BilletterieBundle\Entity\Paiement;
use BilletterieBundle\Form\PaiementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Forms;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
       
      // On crée un objet Commande
      $commande = new Commande();
         
      // On crée le FormBuilder grâce au service form factory
      $formBuilder = $this->createFormBuilder($commande);

      
      // On ajoute les champs de l'entité que l'on veut à notre formulaire
      $formBuilder
        ->add('dateVisite', DateType::class, [
                  'widget' => 'single_text',
              ])
        ->add('journeeEntiere')
        ->add('save', SubmitType::class)
      ;
      
      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();
      
      $form->handleRequest($request);       

      // par défaut, on envoie sur la page d'accueil
      return $this->render('BilletterieBundle:Default:index.html.twig', [
          'commande' => $commande,
          'formCommande' => $form->createView(),
          ]);   
    }
    
    public function indexPostAction(Request $request)
    {
      // On récupére la commande en cours avec find()
      $session = $request->getSession();
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
        
      $formBuilder = $this->createFormBuilder($commande);
      // On ajoute les champs de l'entité que l'on veut à notre formulaire
      $formBuilder
        ->add('dateVisite', DateType::class, array(
                  'widget' => 'single_text',
              ))
        ->add('journeeEntiere')
        ->add('save', SubmitType::class)
      ;
      $form = $formBuilder->getForm();
      $form->handleRequest($request);
             
      // On récupère le service validator
      $validator = $this->get('validator');
         
      // On déclenche la validation sur notre object
      $listErrors = $validator->validate($commande);
  
      // Si le tableau n'est pas vide, on affiche les erreurs
      if(count($listErrors) > 0) {
        return new Response(print_r($listErrors, true));
      } else {
        // on persiste
        $em = $this->getDoctrine()->getManager();   
        $em->persist($commande);   
        $em->flush();   

        // je mémorise l'identifiant de commande dans la session
        $session = $request->getSession();
        $session->set('id_commande', $commande->getId());
            
        // on redirige vers la page de configuration des billets
        return $this->redirect($this->generateUrl('billetterie_billets'));                   
      }          
    }
       
    public function billetsAction(Request $request)
    {
      
      // On récupére la commande en cours avec find()
      $session = $request->getSession();
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
        
      // On vérifie que la commande existe bien
      if ($commande === null) {
        throw $this->createNotFoundException("Pas de commande en cours.");
        // on pourrait aussi rediriger automatiquement vers l'accueil
      }
          
      // On crée le FormBuilder grâce au service form factory
      $formBuilder = $this->createFormBuilder($commande)
           ->add('billets', CollectionType::class, [
              'entry_type' => BilletType::class,
              'allow_add'    => true,
              'allow_delete' => true,
            ])
      ;    
      
      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();
      
      // par défaut, on envoie sur la page des billets
      return $this->render('BilletterieBundle:Default:billets.html.twig', [
          'commande' => $commande,
          'form' => $form->createView(),
          ]); 
    }
    
    public function billetsPostAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();   
      
      // On récupére la commande en cours avec find()
      $session = $request->getSession();  
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
      
      // on mémorise les billets initialement demandés
      $originalBillets = new ArrayCollection();
      foreach ($commande->getBillets() as $billet) {
        $originalBillets->add($billet);
      }
      
      // le by_reference a résolu le pb de l'ajout de l'ID de la commande   
      $formBuilder = $this->createFormBuilder($commande)
           ->add('billets', CollectionType::class, [
              'entry_type' => BilletType::class,
              'allow_add'    => true,
              'allow_delete' => true,
              'by_reference' => false,
            ])
      ;
      $form = $formBuilder->getForm();
      $form->handleRequest($request);
      
        // suppression des billets supprimés manuellement par l'internaute
        foreach ($originalBillets as $billet) {
              if (false === $commande->getBillets()->contains($billet)) {
                  //die("il manque le billet n°".$billet->getId());
                  $commande->getBillets()->removeElement($billet);
                  $em->remove($billet);
              }      
        }
                 
      // On récupère le service validator
      $validator = $this->get('validator');
      
      // On déclenche la validation sur notre object
      $listErrors = $validator->validate($commande);
  
      // Si le tableau n'est pas vide, on affiche les erreurs
      if(count($listErrors) > 0) {
        return new Response(print_r($listErrors, true));
      } else {
        
        // on persiste
        $em = $this->getDoctrine()->getManager();   
        $em->persist($commande);   
        $em->flush();   
            
        // on redirige vers la page de configuration des billets
        return $this->redirect($this->generateUrl('billetterie_payeur'));        
      }                              
    }
    
    public function payeurAction(Request $request)
    {
      // On récupére la commande en cours avec find()
      $session = $request->getSession();
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
        
      // On vérifie que la commande existe bien
      if ($commande === null) {
        throw $this->createNotFoundException("Pas de commande en cours.");
        // on pourrait aussi rediriger automatiquement vers l'accueil
      }
          
      // On crée le FormBuilder grâce au service form factory
      $formBuilder = $this->createFormBuilder($commande)
         ->add('paiement', PaiementType::class)
          ->add('save', SubmitType::class)
      ;    
      
      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();
      
      // par défaut, on envoie sur la page des billets
      return $this->render('BilletterieBundle:Default:payeur.html.twig', [
          'commande' => $commande,
          'form' => $form->createView(),
          ]); 
    }
    
    public function payeurPostAction(Request $request)
    {
      // On récupére la commande en cours avec find()
      $session = $request->getSession();
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
        
      $formBuilder = $this->createFormBuilder($commande)
        ->add('paiement', PaiementType::class)
      ; 
      $form = $formBuilder->getForm();
      $form->handleRequest($request);
      
      // On récupère le service validator
      $validator = $this->get('validator');
      
      // On déclenche la validation sur notre object
      $listErrors = $validator->validate($commande);
  
      // Si le tableau n'est pas vide, on affiche les erreurs
      if(count($listErrors) > 0) {
        return new Response(print_r($listErrors, true));
      } else {
        // on persiste
        $em = $this->getDoctrine()->getManager();   
        $em->persist($commande);   
        $em->flush();   
            
        // on redirige vers la page de configuration des billets
        return $this->redirect($this->generateUrl('billetterie_paiement'));                   
      }          
    }


    public function paiementAction(Request $request)
    {
      // On récupére la commande en cours avec find()
      $session = $request->getSession();
      $commande = $this->getDoctrine()
        ->getRepository('BilletterieBundle:Commande')
        ->find($session->get('id_commande'));
        
      // On vérifie que la commande existe bien
      if ($commande === null) {
        throw $this->createNotFoundException("Pas de commande en cours.");
        // on pourrait aussi rediriger automatiquement vers l'accueil
      }
          
      // On crée le FormBuilder grâce au service form factory
      $formBuilder = $this->createFormBuilder($commande)
         ->add('paiement', PaiementType::class)
          ->add('save', SubmitType::class)
      ;    
      
      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();
      
      // par défaut, on envoie sur la page des billets
      return $this->render('BilletterieBundle:Default:payeur.html.twig', [
          'commande' => $commande,
          'form' => $form->createView(),
          ]); 
    }    
}
