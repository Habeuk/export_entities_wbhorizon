<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\lesroidelareno\lesroidelareno;

trait HelperRessources {
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\jsonapi_resources\Resource\EntityQueryResourceBase::getEntityQuery()
   */
  protected function getEntityQuery($entity_type_id) {
    if (!lesroidelareno::userIsAdministratorSite() && !lesroidelareno::isAdministrator())
      throw new \Exception(" Vous n'avez pas les droits necessaire pour exporter le site : " . lesroidelareno::getCurrentDomainId());
    
    /**
     *
     * @var \Drupal\Core\Entity\Query\QueryInterface $entity_query
     */
    $entity_query = parent::getEntityQuery($entity_type_id);
    $field_domain_access = \Drupal\domain_access\DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD;
    $entity_query->condition($field_domain_access, lesroidelareno::getCurrentDomainId());
    return $entity_query;
  }
  
  /**
   * Permet de retourner le nombre de données respectant les contraintes.
   *
   * @param string $entity_type_id
   * @return number|array
   */
  public function countEntities($entity_type_id) {
    /**
     *
     * @var \Drupal\Core\Entity\Query\QueryInterface $entity_query
     */
    $entity_query = $this->getEntityQuery($entity_type_id);
    return $entity_query->count()->execute();
  }
  
}
