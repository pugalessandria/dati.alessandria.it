<?php

namespace PugAl\Bundle\OdalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Search extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('keywords', 'text', array('label'  => 'Cerca nei datasets'))
      ->add('cerca', 'submit');
  }

  public function getName() {
    return 'search';
  }
}
