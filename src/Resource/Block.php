<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\export_import_entities\Resource\BaseEntities;
use Drupal\lesroidelareno\lesroidelareno;

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