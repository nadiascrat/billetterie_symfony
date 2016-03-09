<?php

namespace BilletterieBundle\Controller;

use BilletterieBundle\Entity\Commande;
use BilletterieBundle\Form\CommandeType;
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
        ->add('dateVisite', DateType::class)
        ->add('journeeEntiere',TextType::class)
        ->add('nbBillets', TextType::class)
        ->add('save', SubmitType::class)
      ;
      
      // À partir du formBuilder, on génère le formulaire
      $form = $formBuilder->getForm();

      
        // si on reçoit des infos en POST, c'est qu'un internaute veut passer commande
        if ($request->isMethod('POST')) {
    
          $em = $this->getDoctrine()->getManager();   
          $em->persist($commande);   
          $em->flush();   
    
          $request->getSession()->getFlashBag()->add('notice', 'Commande initialisée.');
          
          $nbBillets = $commande->nbBillets;
          return $this->redirect($this->generateUrl('billets', array(
            'nbBillets' => $nbBillets
          )));   
        }
        
        

        return $this->render('BilletterieBundle:Default:index.html.twig', array(
            'commande' => $commande,
            'formCommande' => $form->createView()
            ));   
    }
    
    public function billetsAction(Request $request)
    {
          $nbBillets = 2;    
        // si on reçoit des infos en POST, c'est qu'un internaute veut passer commande
        if ($request->isMethod('POST')) {
    
          /*
          $em = $this->getDoctrine()->getManager();   
          $em->persist($advert);   
          $em->flush();   
    
          $request->getSession()->getFlashBag()->add('notice', 'Commande initialisée.');
          */

          return $this->redirect($this->generateUrl('billets', array(
            'nbBillets' => $nbBillets
          )));   
        }
        
        // si le visiteur vient d'arriver, on lui présente le formulaire de la page d'accueil
        return $this->render('BilletterieBundle:Default:billets.html.twig', array(
            'nbBillets' => $nbBillets
            ));
    }
}
