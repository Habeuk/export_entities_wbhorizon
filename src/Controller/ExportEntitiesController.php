<?php

namespace Drupal\export_entities_wbhorizon\Controller;

use Drupal\Core\Controller\ControllerBase;
use Stephane888\DrupalUtility\HttpResponse;
use Stephane888\Debug\Repositories\ConfigDrupal;
use Drupal\export_entities_wbhorizon\Resource\CountEntities;
use Drupal\export_entities_wbhorizon\Resource\MenuLinkContent;

/**
 * --
 *
 * @author stephane
 *        
 */
class ExportEntitiesController extends ControllerBase {
  
  /**
   *
   * @param string $entity_id
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function CountEntities($entity_id) {
    switch ($entity_id) {
      case 'menu_link_content':
        $MenuLinkContent = new MenuLinkContent();
        $MenuLinkContent->setEntityTypeManager(\Drupal::entityTypeManager());
        $nbre = $MenuLinkContent->countEntities($entity_id);
        break;
      
      default:
        $BaseEntities = new CountEntities();
        $BaseEntities->setEntityTypeManager(\Drupal::entityTypeManager());
        $nbre = $BaseEntities->countEntities($entity_id);
        break;
    }
    
    return HttpResponse::response($nbre);
  }
  
  public function ShowSiteConfig() {
    /**
     * Get default langue :
     * Lorsqu'on generer un site ce dernier n'est pas reelement dans la bonne
     * langue, mais ces contenus y sont.
     */
    $config = ConfigDrupal::config('system.site');
    $LanguageManager = \Drupal::languageManager();
    $enableLanguage = $LanguageManager->getLanguages();
    $defaultLanguage = $LanguageManager->getDefaultLanguage();
    /**
     * à prtir de la page d'ccueil on determiné la langue par defaut.
     * ( specifique à wb-horizon).
     */
    if (!empty($config['page']['front'])) {
      $page = explode("/", $config['page']['front']);
      if ($page[1] == 'site-internet-entity') {
        /**
         *
         * @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntity $homePage
         */
        $homePage = $this->entityTypeManager()->getStorage('site_internet_entity')->load($page[2]);
      }
      if (!empty($homePage)) {
        $config['langcode'] = $homePage->language()->getId();
        $config['default_langcode'] = $homePage->language()->getId();
      }
    }
    return HttpResponse::response([
      'system.site' => $config
    ]);
  }
  
}