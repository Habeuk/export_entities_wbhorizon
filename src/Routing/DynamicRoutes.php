<?php

namespace Drupal\export_entities_wbhorizon\Routing;

use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes.
 */
class DynamicRoutes {
  
  /**
   *
   * {@inheritdoc}
   */
  public function routes() {
    $routes = [];
    $this->routeForMainMenu($routes);
    $this->routeForEvreryParagraph($routes);
    $this->routeForBlocksContents($routes);
    $this->routeForSiteInternetEntity($routes);
    $this->routeForNodes($routes);
    $this->routeForBlockContent($routes);
    $this->routeForMultis($routes);
    return $routes;
  }
  
  /**
   * _role: 'gerant_de_site_web+administrator'
   *
   * @param array $routes
   */
  public function routeForMultis(array &$routes) {
    $resource_types = [
      'config_theme_entity--config_theme_entity'
    ];
    $routes['export_entities_wbhorizon.config_theme_entity'] = new Route('/%jsonapi%/export-entities-wbhorizon/config_theme_entity', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\ConfigThemeEntity',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
    //
    $resource_types = [
      'block--block'
    ];
    $routes['export_entities_wbhorizon.block'] = new Route('/%jsonapi%/export-entities-wbhorizon/block', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\Block',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  /**
   * _role: 'gerant_de_site_web+administrator'
   *
   * @param array $routes
   */
  public function routeForBlockContent(array &$routes) {
    /**
     * Routes pour tous les produits.
     */
    $entities_types = \Drupal::entityTypeManager()->getStorage('block_content_type')->loadMultiple();
    $resource_types = [];
    foreach ($entities_types as $entity_type) {
      $resource_types[] = 'block_content--' . $entity_type->id();
    }
    $routes['export_entities_wbhorizon.block_content'] = new Route('/%jsonapi%/export-entities-wbhorizon/block_content', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\BlockContent',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  public function routeForBlocksContents(array &$routes) {
    /**
     * Routes pour tous les produits.
     */
    $blocks_contents_types = \Drupal::entityTypeManager()->getStorage('blocks_contents_type')->loadMultiple();
    $resource_types = [];
    foreach ($blocks_contents_types as $blocks_contents_type) {
      $resource_types[] = 'blocks_contents--' . $blocks_contents_type->id();
    }
    $routes['export_entities_wbhorizon.blocks_contents'] = new Route('/%jsonapi%/export-entities-wbhorizon/blocks_contents', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\BlocksContents',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  /**
   * _role: 'gerant_de_site_web+administrator'
   *
   * @param array $routes
   */
  public function routeForSiteInternetEntity(array &$routes) {
    /**
     * Routes pour tous les produits.
     */
    $entities_types = \Drupal::entityTypeManager()->getStorage('site_internet_entity_type')->loadMultiple();
    $resource_types = [];
    foreach ($entities_types as $entity_type) {
      $resource_types[] = 'site_internet_entity--' . $entity_type->id();
    }
    $routes['export_entities_wbhorizon.site_internet_entity'] = new Route('/%jsonapi%/export-entities-wbhorizon/site_internet_entity', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\SiteInternetEntity',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  /**
   * _role: 'gerant_de_site_web+administrator'
   *
   * @param array $routes
   */
  public function routeForNodes(array &$routes) {
    /**
     * Routes pour tous les produits.
     */
    $entities_types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();
    $resource_types = [];
    foreach ($entities_types as $entity_type) {
      $resource_types[] = 'node--' . $entity_type->id();
    }
    $routes['export_entities_wbhorizon.node'] = new Route('/%jsonapi%/export-entities-wbhorizon/node', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\Node',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  /**
   * Route permettant de retourner tous les paragraphes.
   *
   * @param array $routes
   */
  public function routeForEvreryParagraph(array &$routes) {
    /**
     * Routes pour tous les paragraphes.
     */
    $paragraphs_type = \Drupal::entityTypeManager()->getStorage('paragraphs_type')->loadMultiple();
    $resource_types = [];
    foreach ($paragraphs_type as $paragraph_type) {
      $resource_types[] = 'paragraph--' . $paragraph_type->id();
    }
    $routes['export_entities_wbhorizon.paragraph'] = new Route('/%jsonapi%/export-entities-wbhorizon/paragraph', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\ParagraphContent',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
    
    /**
     * Routes pour tous les produits.
     */
    $commerce_product_types = \Drupal::entityTypeManager()->getStorage('commerce_product_type')->loadMultiple();
    $resource_types = [];
    foreach ($commerce_product_types as $commerce_product_type) {
      $resource_types[] = 'commerce_product--' . $commerce_product_type->id();
    }
    $routes['export_entities_wbhorizon.commerce_product'] = new Route('/%jsonapi%/export-entities-wbhorizon/commerce_product', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\CommerceProduct',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
  /**
   * Permet de generer une route d'export pour chaque menu principal.
   *
   * @param array $routes
   */
  protected function routeForMainMenu(array &$routes) {
    $entity_query = \Drupal::entityTypeManager()->getStorage('menu')->getQuery();
    $or = $entity_query->orConditionGroup();
    // Ce ci est fait pour les anciens sites.
    $or->condition('id', '_main', 'CONTAINS'); // old
    $or->condition('id', '-main', 'CONTAINS'); // new
    $entity_query->condition($or);
    // $entity_query->g
    $ids = $entity_query->execute();
    $resource_types = [];
    foreach ($ids as $id) {
      $resource_types[] = 'menu_link_content--' . $id;
    }
    $routes['export_entities_wbhorizon.menu_link_content'] = new Route('/%jsonapi%/export-entities-wbhorizon/menu_link_content', [
      '_jsonapi_resource' => 'Drupal\export_entities_wbhorizon\Resource\MenuLinkContent',
      '_jsonapi_resource_types' => $resource_types,
      'requirements' => [
        '_permission' => 'access content',
        '_user_is_logged_in' => TRUE,
        '_auth' => 'basic_auth'
      ]
    ]);
  }
  
}