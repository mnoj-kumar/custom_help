<?php

namespace Drupal\custom_help\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Custom Help type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "custom_help_type",
 *   label = @Translation("Custom help type"),
 *   label_collection = @Translation("Custom help types"),
 *   handlers = {
 *     "access" = "Drupal\custom_help\CustomHelpTypeAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\custom_help\Form\CustomHelpTypeForm",
 *       "edit" = "Drupal\custom_help\Form\CustomHelpTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\custom_help\CustomHelpTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer custom help types",
 *   bundle_of = "custom_help",
 *   config_prefix = "custom_help_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/help/custom-help/types/add",
 *     "edit-form" = "/admin/help/custom-help/types/manage/{custom_help_type}",
 *     "delete-form" = "/admin/help/custom-help/types/manage/{custom_help_type}/delete",
 *     "collection" = "/admin/help/custom-help/types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "uuid",
 *   }
 * )
 */
class CustomHelpType extends ConfigEntityBundleBase {

  /**
   * The machine name of this custom help type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the custom help type.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this custom help type.
   *
   * @var string
   */
  protected $description;

  /**
   * Gets the description.
   *
   * @return string
   *   The description of this custom help type.
   */
  public function getDescription() {
    return $this->description;
  }

}
