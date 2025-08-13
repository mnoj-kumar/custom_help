<?php

namespace Drupal\custom_help;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the custom help type entity type.
 *
 * @see \Drupal\custom_help\Entity\CustomHelpType
 */
class CustomHelpTypeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermissions($account, [
          'administer custom help',
          'view ' . $entity->id() . ' custom help',
        ], 'OR');

      default:
        return parent::checkAccess($entity, $operation, $account);
    }
  }

}
