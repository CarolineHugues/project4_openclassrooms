<?php
// src/project4OC/BookingBundle/Form/BookingType.php

namespace project4OC\BookingBundle\Form;

use Symfony\Component\Form\AbstractType;
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
      ->add('ticketType',      ChoiceType::class, array(
        'choices' => array(
          'Journée' => 'day_ticketType',
          'Demi-journée' => 'halfDay_ticketType',
        ),
        'expanded' => true
      ))
      ->add('mail',            EmailType::class)
      ->add('numberOfTickets', IntegerType::class)
      ->add('tickets',         CollectionType::class, array(
        'entry_type'   =>      TicketType::class,
        'allow_add'    => true,
        'allow_delete' => true
      ))
      ->add('save',            SubmitType::class);
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'project4OC\BookingBundle\Entity\Booking'));
  }
}