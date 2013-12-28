<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends CachedController {

  /**
   * @Route("/")
   */
  public function indexAction() {
    $content = $this->renderView(
      'PugAlOdalBundle:Default:index.html.twig',
      array('title' => NULL)
    );

    return $this->returnResponse($content);
  }

  /**
   * @Route("/blog", name="blog")
   */
  public function blogAction() {
    return $this->redirect('http://alessandriaopendata.wordpress.com');
  }

  /**
   * @Route("/chi-siamo", name="chisiamo")
   */
  public function chisiamoAction() {
    $rss = $this->get('rss_client');

    $content = $this->renderView(
      'PugAlOdalBundle:Default:chisiamo.html.twig',
      array(
        'title' => 'Chi siamo',
        'feeds' => $rss->fetch('blog', 5),
      )
    );

    return $this->returnResponse($content);
  }

  /**
   * @Route("/applicazioni", name="applicazioni")
   */
  public function applicazioniAction() {
    $rss = $this->get('rss_client');

    $content = $this->renderView(
      'PugAlOdalBundle:Default:applicazioni.html.twig',
      array(
        'title' => 'Applicazioni',
        'feeds' => $rss->fetch('blog', 5),
      )
    );

    return $this->returnResponse($content);
  }

}
