<?php

namespace BilletterieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BilletType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('nationalite', ChoiceType::class, [
                      'choices' => array(
                          'France'=>'France',
                          'Afrique'=>'Afrique',
                          'Amérique du Nord'=>'Amérique du Nord',
                          'Amérique du Sud'=>'Amérique du Sud',
                          'Asie'=>'Asie',
                          'Europe (hors France)'=>'Europe',
                          'Eurasie'=>'Eurasie'                      
                      )
                  ])
            ->add('dateNaissance', BirthdayType::class, [
                      'format' => 'dd MMM yyyy',
                      'widget' => 'choice',
                      'attr' => array(
                          'class' => 'dateNaissance'
                      )
                  ])
            ->add('tarifSpecial', CheckboxType::class, [
                      'label'    => "Cochez la case suivante pour bénéficier du tarif spécial (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire) ",
                      'required' => false,
                      'attr' => array(
                      'class' => 'tarifSpecial'
                    )
                  ]);
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BilletterieBundle\Entity\Billet'
        ));
    }
}
