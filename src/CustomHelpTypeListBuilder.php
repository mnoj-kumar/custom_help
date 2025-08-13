<?php

namespace Drupal\custom_help;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of custom help type entities.
 *
 * @see \Drupal\custom_help\Entity\CustomHelpType
 */
class CustomHelpTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');
    $header['description'] = [
      'data' => t('Description'),
      'class' => [RESPONSIVE_PRIORITY_MEDIUM],
    ];

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\custom_help\Entity\CustomHelpType $entity */
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];
    $row['description']['data'] = [
      '#markup' => $entity->getDescription(),
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();
    $build['table']['#empty'] = $this->t(
      'No custom help types available. <a href=":link">Add custom help type</a>.',
      [':link' => Url::fromRoute('entity.custom_help_type.add_form')->toString()]
    );

    return $build;
  }

}
