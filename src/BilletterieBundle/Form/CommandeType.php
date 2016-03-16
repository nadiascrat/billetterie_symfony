<?php

namespace BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use BilletterieBundle\Entity\BilletType;

class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisite', DateType::class, array(
                  'widget' => 'single_text',
              ))
            ->add('journeeEntiere')
            ->add('ipClient')
            /*
             ** - 1er argument : nom du champ, ici « billet », car c'est le nom de l'attribut
             ** - 2e argument : type du champ, ici « collection » qui est une liste de quelque chose
             ** - 3e argument : tableau d'options du champ
             */
            ->add('billets', CollectionType::class, array(
              'entry_type' => BilletType::class,
              'allow_add'    => true,
              'allow_delete' => true,
            ))
            ->add('save', SubmitType::class)            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BilletterieBundle\Entity\Commande'
        ));
    }
}
