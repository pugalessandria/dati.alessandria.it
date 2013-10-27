<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Guzzle\Http\Client;

class ApiController extends Controller {

  /**
   * @Route("/api/1.0/search", name="api_search")
   */
  public function searchAction(Request $request) {
    $keywords = $request->query->get('keywords');
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

    $jsonResponse = new Response(json_encode($results));
    $jsonResponse->headers->set('Content-Type', 'application/json');
    return $jsonResponse;
  }


  /**
   * @Route("/api/1.0/dataset/{id}", name="api_dataset")
   */
  public function datasetAction(Request $request, $id) {
    $client = new Client('http://www.dati.piemonte.it');
    $request = $client->get('/rpapisrv/api/rest/package/' . $id);
    $response = $request->send();
    $body = $response->json();

    $jsonResponse = new Response(json_encode($body));
    $jsonResponse->headers->set('Content-Type', 'application/json');
    return $jsonResponse;
  }
}
