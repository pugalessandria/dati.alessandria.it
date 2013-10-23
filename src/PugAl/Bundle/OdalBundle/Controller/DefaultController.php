<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
  public function indexAction() {
    return $this->render('PugAlOdalBundle:Default:index.html.twig');
  }
}
