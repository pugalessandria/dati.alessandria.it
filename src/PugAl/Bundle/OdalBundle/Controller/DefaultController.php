<?php

namespace PugAl\Bundle\OdalBundle\Controller;

use PugAl\Bundle\OdalBundle\Form\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
    $content = $this->renderView(
      'PugAlOdalBundle:Default:chisiamo.html.twig',
      array(
        'title' => 'Chi siamo',
      )
    );

    return $this->returnResponse($content);
  }

  /**
   * @Route("/applicazioni", name="applicazioni")
   */
  public function applicazioniAction() {
    $content = $this->renderView(
      'PugAlOdalBundle:Default:applicazioni.html.twig',
      array(
        'title' => 'Applicazioni',
      )
    );

    return $this->returnResponse($content);
  }

  /**
   *
   */
  public function blogBlockAction() {
    $rss = $this->get('rss_client');

    $content = $this->renderView(
      'PugAlOdalBundle:Default:blog.html.twig',
      array(
        'feeds' => $rss->fetch('blog', 5),
      )
    );

    return $this->returnResponse($content);
  }

  /**
   *
   */
  public function searchAction() {
    $form = $this->createForm(new Search(), NULL, array('action' => $this->generateUrl('datasets')));

    return $this->render('PugAlOdalBundle:Default:search.html.twig', array(
      'form' => $form->createView(),
    ));
  }

}
