<?php

namespace PugAl\Bundle\OdalBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware {

  /**
   *
   */
  public function mainMenu(FactoryInterface $factory, array $options) {
    $menu = $factory->createItem('root');

    $menu->addChild('Datasets', array('route' => 'datasets'));
    $menu->addChild('Chi siamo', array('route' => 'chisiamo'));
    $menu->addChild('Applicazioni', array('route' => 'applicazioni'));
    $menu->addChild('Blog', array('route' => 'blog'));

    return $menu;
  }

  /**
   *
   */
  protected function createDropdownMenuItem(ItemInterface $rootItem, $title, $knp_item_options = array()) {
    $rootItem
      ->setAttribute('class', 'nav');
    $dropdown = $rootItem->addChild($title, array_merge($knp_item_options, array('uri' => '#')))
      ->setLinkattribute('class', 'dropdown-toggle')
      ->setLinkattribute('data-toggle', 'dropdown')
      ->setAttribute('class', 'dropdown')
      ->setChildrenAttribute('class', 'dropdown-menu');

    return $dropdown;
  }

}
