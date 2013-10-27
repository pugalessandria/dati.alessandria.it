<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DatasetController extends Controller {

  /**
   * @Route("/dataset", name="dataset")
   * @Template()
   */
  public function datasetAction(Request $request) {
    return array(
      'title' => 'Dataset',
    );
  }

}
