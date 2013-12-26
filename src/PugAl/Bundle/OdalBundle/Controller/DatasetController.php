<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DatasetController extends Controller {

  /**
   * @Route("/datasets", name="datasets")
   * @Template()
   */
  public function datasetsAction(Request $request) {
    $datasets = $this->get('pug_al_odal.ApiClient')->listAll();

    $response = new Response();

    $content = $this->renderView(
      'AcmeHelloBundle:Hello:index.html.twig',
      array('title' => 'Datasets', 'datasets' => $datasets,)
    );
    $response->setMaxAge(600);

    return new Response($content);
  }

  /**
   * @Route("/dataset/{id}", name="dataset")
   * @Template()
   */
  public function datasetAction(Request $request, $id) {
    $dataset = $this->get('pug_al_odal.ApiClient')->getDataset($id);
    var_dump($dataset);

    return array(
      'title' => $dataset['title'],
      'dataset' => $dataset,
    );
  }

}
