<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\export_import_entities\Resource\BaseEntities;
use Drupal\lesroidelareno\lesroidelareno;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\jsonapi\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Permet de retourner les pages en function du domaine.
 *
 * @internal
 */
class Block extends BaseEntities {
  use HelperRessources;
  /**
   *
   * @var string
   */
  protected $entity_id = "block";
  
  /**
   * Process the resource request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *        The request.
   * @param \Drupal\user\UserInterface $user
   *        The user.
   *        
   * @return \Drupal\jsonapi\ResourceResponse The response.
   *        
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function process(Request $request): ResourceResponse {
    $cacheability = new CacheableMetadata();
    $entity_query = $this->getEntityQuery($this->getEntityId());
    $cacheability->addCacheContexts([
      'url.path'
    ]);
    
    $paginator = $this->getPaginatorForRequest($request);
    $paginator->applyToQuery($entity_query, $cacheability);
    $check_access = false;
    $load_latest_revisions = false;
    /**
     *
     * @var \Drupal\jsonapi\JsonApiResource\ResourceObjectData $data
     */
    $data = $this->loadResourceObjectDataFromEntityQuery($entity_query, $cacheability, $load_latest_revisions, $check_access);
    $pagination_links = $paginator->getPaginationLinks($entity_query, $cacheability, TRUE);
    // dd($data);
    /**
     *
     * @var \Drupal\jsonapi\CacheableResourceResponse $response
     */
    $response = $this->createJsonapiResponse($data, $request, 200, [], $pagination_links);
    $response->addCacheableDependency($cacheability);
    
    return $response;
  }
  
  /**
   * On va devoir construire une fonction qui retourne les données similaire à
   * celui de JSON.
   */
  private function getEntityFromJSONAPI($entity_query) {
    //
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\jsonapi_resources\Resource\EntityQueryResourceBase::getEntityQuery()
   */
  protected function getEntityQuery($entity_type_id) {
    if (!lesroidelareno::userIsAdministratorSite() && !lesroidelareno::isAdministrator())
      throw new \Exception("Vous n'avez pas les droits necessaire pour exporter le site");
    
    /**
     *
     * @var \Drupal\Core\Entity\Query\QueryInterface $entity_query
     */
    $entity_query = parent::getEntityQuery($entity_type_id);
    $entity_query->condition('theme', lesroidelareno::getCurrentDomainId());
    return $entity_query;
  }
}