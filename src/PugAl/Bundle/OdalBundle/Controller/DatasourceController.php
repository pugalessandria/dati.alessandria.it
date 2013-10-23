<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DatasourceController extends Controller {
  /**
   * @Route("/list", name="list")
   * @Template()
   */
  public function listAction() {
    return $this->render('PugAlOdalBundle:Datasource:list.html.twig');
  }

}
