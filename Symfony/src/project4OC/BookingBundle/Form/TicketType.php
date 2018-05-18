<?php
// src/project4OC/BookingBundle/Form/TicketType.php

namespace project4OC\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('name',        TextType::class)
      ->add('surname',     TextType::class)
      ->add('birthdate',   BirthdayType::class, array(
        'placeholder' => array(
          'day' => 'Jour', 'month' => 'Mois', 'year' => 'Année', 
        ),
        'format' => 'dd MM yyyy',
      ))
      ->add('country',     CountryType::class, array(
        'placeholder' => ' ',
      ))
      ->add('reducedRate', CheckboxType::class, array('required' => false))
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'project4OC\BookingBundle\Entity\Ticket'));
  }
}
