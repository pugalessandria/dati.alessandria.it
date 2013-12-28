<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DatasetController extends CachedController {

  /**
   * @Route("/datasets", name="datasets")
   */
  public function datasetsAction(Request $request) {
    $datasets = $this->get('pug_al_odal.ApiClient')->listAll();

    $content = $this->renderView(
      'PugAlOdalBundle:Dataset:datasets.html.twig',
      array('title' => 'Datasets', 'datasets' => $datasets)
    );

    return $this->returnResponse($content);
  }

  /**
   * @Route("/dataset/{id}", name="dataset")
   */
  public function datasetAction(Request $request, $id) {
    $dataset = $this->get('pug_al_odal.ApiClient')->getDataset($id);

    $content = $this->renderView(
      'PugAlOdalBundle:Dataset:dataset.html.twig',
      array('title' => $dataset['title'], 'dataset' => $dataset)
    );

    return $this->returnResponse($content);
  }

}
