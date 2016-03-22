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
      // On crée un objet Commande
      $commande = new Commande();
 
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
            
        // on redirige vers la page de configuration des billets
        return $this->redirect($this->generateUrl('billetterie_billets'));                   
      }          
    }
       
    public function billetsAction(Request $request)
    {
      $commande = new Commande();
      
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
  
      // On récupére la commande en cours avec findBy(), en se basant sur l'IP
      $commande = $em->createQueryBuilder()
        ->select('e')
        ->from('BilletterieBundle:Commande', 'e')
        ->orderBy('e.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        
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
      // On crée un objet Commande
      $commande = new Commande();
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
  
      // On récupére la commande en cours avec findBy(), en se basant sur l'IP
      $commande = $em->createQueryBuilder()
        ->select('e')
        ->from('BilletterieBundle:Commande', 'e')
        ->orderBy('e.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        
      $formBuilder = $this->createFormBuilder($commande)
           ->add('billets', CollectionType::class, [
              'entry_type' => BilletType::class,
              'allow_add'    => true,
              'allow_delete' => true,
            ])
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
        return $this->redirect($this->generateUrl('billetterie_payeur'));        
      }                              
    }
    
    public function payeurAction(Request $request)
    {
      $commande = new Commande();
      
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
  
      // On récupére la commande en cours avec findBy(), en se basant sur l'IP
      $commande = $em->createQueryBuilder()
        ->select('e')
        ->from('BilletterieBundle:Commande', 'e')
        ->orderBy('e.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        
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
      // On crée un objet Commande
      $commande = new Commande();
      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();
  
      // On récupére la commande en cours avec findBy(), en se basant sur l'IP
      $commande = $em->createQueryBuilder()
        ->select('e')
        ->from('BilletterieBundle:Commande', 'e')
        ->orderBy('e.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        
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
    
}
