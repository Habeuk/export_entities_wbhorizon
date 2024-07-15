<?php

namespace Drupal\export_entities_wbhorizon\Resource;

use Drupal\lesroidelareno\lesroidelareno;

/**
 * Permet de retourner les pages en function du domaine.
 *
 * @internal
 */
class CommerceShipping extends BaseEntities {
  use HelperRessources;
  /**
   *
   * @var string
   */
  protected $entity_id = "commerce_shipping_method";
}
