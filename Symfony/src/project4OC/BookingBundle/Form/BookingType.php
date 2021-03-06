<?php
// src/project4OC/BookingBundle/Form/BookingType.php

namespace project4OC\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
use project4OC\BookingBundle\Form\VisitDayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use project4OC\BookingBundle\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder 
      ->add('mail',            EmailType::class, array(
        'label' => 'Veuillez renseigner votre adresse mail pour pouvoir réserver :',
      ))
      ->add('visitDay',   VisitDayType::class, array(
        'label' => ' '
      ))
      ->add('ticketType',      ChoiceType::class, array(
        'label' => 'Type de billet',
        'choices' => array(
          'Journée' => 'day_ticketType',
          'Demi-journée' => 'halfDay_ticketType',
        ),
        'expanded' => true,
        'placeholder' => false,
      ))
      ->add('numberOfTickets', IntegerType::class, array(
        'label' => 'Nombre de billets',
      ))
      ->add('tickets',         CollectionType::class, array(
        'entry_type'   =>      TicketType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'by_reference' => false,
        'label' => 'Veuillez renseigner les informations suivantes pour chaque visiteur :'
      ))
      ->add('save',            SubmitType::class, array(
        'label' => 'Valider sa réservation',
      ))
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'project4OC\BookingBundle\Entity\Booking'));
  }
}