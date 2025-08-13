<?php

namespace Drupal\custom_help;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a custom help entity type.
 */
interface CustomHelpInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Cache path tag name.
   */
  const PATH_CACHE_TAG = 'custom_help.path';

  /**
   * Gets the custom help title.
   *
   * @return string
   *   Title of the custom help.
   */
  public function getTitle();

  /**
   * Sets the custom help title.
   *
   * @param string $title
   *   The custom help title.
   *
   * @return \Drupal\custom_help\CustomHelpInterface
   *   The called custom help entity.
   */
  public function setTitle($title);

  /**
   * Gets the custom help creation timestamp.
   *
   * @return int
   *   Creation timestamp of the custom help.
   */
  public function getCreatedTime();

  /**
   * Sets the custom help creation timestamp.
   *
   * @param int $timestamp
   *   The custom help creation timestamp.
   *
   * @return \Drupal\custom_help\CustomHelpInterface
   *   The called custom help entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the custom help status.
   *
   * @return bool
   *   TRUE if the custom help is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the custom help status.
   *
   * @param bool $status
   *   TRUE to enable this custom help, FALSE to disable.
   *
   * @return \Drupal\custom_help\CustomHelpInterface
   *   The called custom help entity.
   */
  public function setStatus($status);

}
