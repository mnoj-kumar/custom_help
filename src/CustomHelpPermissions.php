<?php

namespace Drupal\custom_help;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\custom_help\Entity\CustomHelpType;

/**
 * Provides dynamic permissions for nodes of different types.
 */
class CustomHelpPermissions {

  use StringTranslationTrait;

  /**
   * Returns an array of custom help text type permissions.
   *
   * @return array
   *   The text type permissions.
   *   @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function textTypePermissions() {
    $perms = [];
    // Generate permissions for all custom help text types.
    foreach (CustomHelpType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of custom help text permissions for a given type.
   *
   * @param \Drupal\custom_help\Entity\CustomHelpType $type
   *   The text type.
   *
   * @return array
   *   An associative array of permission names and descriptions.
   */
  protected function buildPermissions(CustomHelpType $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "view $type_id custom help" => [
        'title' => $this->t('View %type_name custom help texts', $type_params),
        'description' => $this->t('View any enabled %type_name custom help text.', $type_params),
      ],
      "manage $type_id custom help" => [
        'title' => $this->t('Manage %type_name custom help texts', $type_params),
        'description' => $this->t('Create, view, update and delete any %type_name custom help text.', $type_params),
      ],
    ];
  }

}
