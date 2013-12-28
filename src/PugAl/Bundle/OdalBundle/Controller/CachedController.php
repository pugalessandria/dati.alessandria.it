<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class CachedController extends Controller {

  private $cache = TRUE;

  /**
   * @param $content
   * @return Response
   */
  protected function returnResponse($content) {
    $response = new Response($content);

    // caching
    if ($this->cache) {
      $response->setMaxAge(600);
      $response->setPublic();
    }

    return $response;
  }

}
