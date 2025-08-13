<?php

namespace Drupal\custom_help;

use Drupal\Core\Entity\ContentEntityStorageInterface;

/**
 * Defines an interface for custom help entity storage classes.
 */
interface CustomHelpStorageInterface extends ContentEntityStorageInterface {

  /**
   * Load the custom text help that matches a given path.
   *
   * @param string $path
   *   The path.
   *
   * @return \Drupal\custom_help\CustomHelpInterface[]
   *   The custom help text entities found.
   */
  public function loadByPathMatch(string $path);

}
