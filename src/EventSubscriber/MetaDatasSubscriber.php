<?php

namespace Drupal\export_entities_wbhorizon\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\jsonapi\ResourceType\ResourceTypeBuildEvent;
use Drupal\jsonapi\ResourceType\ResourceTypeBuildEvents;

/**
 * JSON API build subscriber that applies all changes from extra's to the API.
 * à partir de la version 10, on peut facilement ajouter des metadatas:
 * https://www.drupal.org/node/3280569
 */
class MetaDatasSubscriber implements EventSubscriberInterface {
  
  /**
   * What events to subscribe to.
   */
  public static function getSubscribedEvents() {
    return [
      ResourceTypeBuildEvents::BUILD => 'AddMetaDatas'
    ];
  }
  
  /**
   *
   * @param ResourceTypeBuildEvent $event
   */
  public function AddMetaDatas(ResourceTypeBuildEvent $event) {
    \Drupal::messenger()->addStatus('getSubscribedEvents for ResourceTypeBuildEvents');
    // dump($event);
  }
  
}