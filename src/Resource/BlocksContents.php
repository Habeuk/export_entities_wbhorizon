<?php

namespace Drupal\export_entities_wbhorizon\Resource;

/**
 * Permet de retourner les pages en function du domaine.
 *
 * @internal
 */
class BlocksContents extends BaseEntities {
  use HelperRessources;
  /**
   *
   * @var string
   */
  protected $entity_id = "blocks_contents";
  
}