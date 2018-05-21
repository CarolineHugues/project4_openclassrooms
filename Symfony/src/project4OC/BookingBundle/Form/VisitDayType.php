<?php
// src/project4OC/BookingBundle/Form/TicketType.php

namespace project4OC\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitDayType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('date',        DateType::class, array(
        'label' => ' ',
        'widget' => 'single_text',
        'html5' => false,
        'attr' => ['class' => 'js-datepicker'],
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'project4OC\BookingBundle\Entity\VisitDay'));
  }
}
