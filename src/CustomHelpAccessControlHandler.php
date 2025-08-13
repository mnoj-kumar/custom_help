<?php

namespace Drupal\custom_help;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the custom help entity type.
 */
class CustomHelpAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    $access_result = parent::checkAccess($entity, $operation, $account);
    if ($access_result->isNeutral()) {
      /** @var \Drupal\custom_help\CustomHelpInterface $entity */
      $manage_permission = 'manage ' . $entity->bundle() . ' custom help';
      // Check permissions by operation and text type.
      switch ($operation) {
        case 'view':
          if ($entity->isEnabled()) {
            // Disabled help texts can be accessed only by administrators.
            $view_permission = 'view ' . $entity->bundle() . ' custom help';
            $access_result = AccessResult::allowedIfHasPermissions($account, [$view_permission, $manage_permission], 'OR');
            break;
          }

        case 'update':
        case 'delete':
          $access_result = AccessResult::allowedIfHasPermission($account, $manage_permission);
          break;

        default:
          // No opinion.
      }
    }

    return $access_result;
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create ' . $entity_bundle . ' custom help', 'administer custom help'], 'OR');
  }

}
