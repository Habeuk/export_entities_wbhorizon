<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\lesroidelareno\lesroidelareno;

/**
 * Permet de retourner les pages en function du domaine.
 *
 * @internal
 */
class MenuLinkContent extends BaseEntities {
  use HelperRessources;
  /**
   *
   * @var string
   */
  protected $entity_id = "menu_link_content";
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\jsonapi_resources\Resource\EntityQueryResourceBase::getEntityQuery()
   */
  protected function getEntityQuery($entity_type_id) {
    if (!lesroidelareno::userIsAdministratorSite() && !lesroidelareno::isAdministrator())
      throw new \Exception("Vous n'avez pas les droits necessaire pour exporter le site : " . lesroidelareno::getCurrentDomainId());
    /**
     *
     * @var \Drupal\Core\Entity\Query\QueryInterface $entity_query
     */
    $entity_query = parent::getEntityQuery($entity_type_id);
    $or = $entity_query->orConditionGroup();
    $or->condition('bundle', lesroidelareno::getCurrentPrefixDomain(false) . '_main');
    $or->condition('bundle', lesroidelareno::getCurrentPrefixDomain(false) . '-main');
    $or->condition('bundle', lesroidelareno::getCurrentPrefixDomain() . '_main');
    $or->condition('bundle', lesroidelareno::getCurrentPrefixDomain() . '-main');
    $entity_query->condition($or);
    return $entity_query;
  }
  
}

