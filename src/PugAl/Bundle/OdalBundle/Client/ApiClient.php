<?php

namespace PugAl\Bundle\OdalBundle\Client;

use Guzzle\Http\Client;

class ApiClient {

  private $url = 'http://www.dati.piemonte.it';

  /**
   * @param null $keywords
   *
   * @return array
   */
  public function listAll($keywords = NULL) {
    $client = new Client($this->url);

    //$request = $client->get('/rpapisrv/api/search/package?q=tag:alessandria+keyword');

    $url = '/rpapisrv/api/search/package?q=alessandria+';
    if ($keywords) {
      $url .= $keywords;
    }
    $request = $client->get($url);

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

    return $results;
  }

  /**
   * @param $id
   *
   * @return array
   */
  public function getDataset($id) {
    $client = new Client($this->url);
    $request = $client->get('/rpapisrv/api/rest/package/' . $id);
    $response = $request->send();
    $body = $response->json();

    return $body;
  }

} 