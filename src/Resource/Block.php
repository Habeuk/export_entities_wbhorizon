<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\export_import_entities\Resource\BaseEntities;
use Drupal\lesroidelareno\lesroidelareno;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\jsonapi\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\jsonapi\JsonApiResource\ResourceObjectData;
use Drupal\jsonapi\JsonApiResource\ResourceObject;

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
  
  function injectResourceDependencies() {
    //
  }
  
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
    // $check_access = false;
    // $load_latest_revisions = false;
    // /**
    // *
    // * @var \Drupal\jsonapi\JsonApiResource\ResourceObjectData $data
    // */
    // $data = $this->loadResourceObjectDataFromEntityQuery($entity_query,
    // $cacheability, $load_latest_revisions, $check_access);
    /**
     * Essaie via la nouvelle methode.
     *
     * @var \Drupal\jsonapi\JsonApiResource\ResourceObjectData $data
     */
    $data = $this->getEntityFromJSONAPI($entity_query, $cacheability);
    //
    $pagination_links = $paginator->getPaginationLinks($entity_query, $cacheability, TRUE);
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
  protected function getEntityFromJSONAPI($entity_query, CacheableMetadata $cacheable_metadata) {
    $entity_type_id = $entity_query->getEntityTypeId();
    $entityQueryExecutor = \Drupal::service("jsonapi_resources.entity_query_executor");
    $ids = $entityQueryExecutor->executeQueryAndCaptureCacheability($entity_query, $cacheable_metadata);
    //
    $storage = $this->entityTypeManager->getStorage($entity_type_id);
    $entities = $storage->loadMultiple($ids);
    //
    $resource_objects = [];
    foreach ($entities as $entity) {
      $resource_objects[$entity->id()] = ResourceObject::createFromEntity($this->resourceTypeRepository->get($entity->getEntityTypeId(), $entity->bundle()), $entity);
    }
    return new ResourceObjectData(array_values($resource_objects));
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