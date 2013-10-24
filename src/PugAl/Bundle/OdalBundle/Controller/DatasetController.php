<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Guzzle\Http\Client;

class DatasetController extends Controller {
  /**
   * @Route("/dataset/list", name="list")
   * @Template()
   */
  public function listAction() {
    /*$client = new Client('http://www.dati.piemonte.it');
    //$request = $client->get('/rpapisrv/api/search/package?q=tag:alessandria+keyword');
    $request = $client->get('/rpapisrv/api/rest/package/100563');
    $response = $request->send();
    $body = $response->json();*/

    return array(
      'title' => 'Tutti i Dataset',
    );
  }

  /**
   * @Route("/dataset/search", name="search")
   * @Template()
   */
  public function searchAction(Request $request) {
    $results = array();

    $form = $this->createFormBuilder()
      ->add('keywords', 'text')
      ->add('cerca', 'submit')
      ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
      $data = $form->getData();
      $keywords = $data['keywords'];
      $client = new Client('http://www.dati.piemonte.it');
      //$request = $client->get('/rpapisrv/api/search/package?q=tag:alessandria+keyword');
      $request = $client->get('/rpapisrv/api/search/package?q=' . $keywords);
      $response = $request->send();
      $body = $response->json();

      $results = array();
      foreach ($body['results'] as $result) {
        $request2 = $client->get('/rpapisrv/api/rest/package/' . $result);
        $response2 = $request2->send();
        $body2 = $response2->json();

        $data = array(
          'title' => $body2['title'],
          'id' => $body2['id'],
        );

        $results[] = $data;
      }
    }

    return array(
      'title' => 'Cerca',
      'form' => $form->createView(),
      'results' => $results,
    );
  }

  /**
   * @Route("/dataset/detail/{dataset}", name="detail")
   * @Template()
   */
  public function detailAction(Request $request, $dataset) {
    $client = new Client('http://www.dati.piemonte.it');
    $request = $client->get('/rpapisrv/api/rest/package/' . $dataset);
    $response = $request->send();
    $body = $response->json();

    return array(
      'title' => $body['title'],
      'body' => $body,
    );
  }

}
