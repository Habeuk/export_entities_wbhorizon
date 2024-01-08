<?php

namespace Drupal\export_entities_wbhorizon\Resource;

/**
 *
 * @author stephane
 *        
 */
class CountEntities extends BaseEntities {
  
  use HelperRessources;
  protected $entityTypeManager;
  
  public function countEntities($entity_type_id) {
    /**
     *
     * @var \Drupal\Core\Entity\Query\QueryInterface $entity_query
     */
    $entity_query = $this->getEntityQuery($entity_type_id);
    return $entity_query->count()->execute();
  }
  
}