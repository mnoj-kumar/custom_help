<?php

namespace Drupal\custom_help\Form;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_help\Entity\CustomHelpType;

/**
 * Form handler for custom help type forms.
 */
class CustomHelpTypeForm extends BundleEntityFormBase {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $entity_type = $this->entity;
    if ($this->operation == 'add') {
      $form['#title'] = $this->t('Add custom help type');
    }
    else {
      $form['#title'] = $this->t(
        'Edit %label custom help type',
        ['%label' => $entity_type->label()]
      );
    }

    $form['label'] = [
      '#title' => $this->t('Label'),
      '#type' => 'textfield',
      '#default_value' => $entity_type->label(),
      '#description' => $this->t('The human-readable name of this custom help type.'),
      '#required' => TRUE,
      '#size' => 30,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity_type->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#machine_name' => [
        'exists' => ['Drupal\custom_help\Entity\CustomHelpType', 'load'],
        'source' => ['label'],
      ],
      '#description' => $this->t('A unique machine-readable name for this custom help type. It must only contain lowercase letters, numbers, and underscores.'),
    ];

    $form['description'] = [
      '#title' => $this->t('Description'),
      '#type' => 'textarea',
      '#default_value' => $entity_type->getDescription(),
      '#description' => $this->t('Brief administrative description of this custom help type.'),
    ];

    return $this->protectBundleIdElement($form);
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Save custom help type');
    $actions['delete']['#value'] = $this->t('Delete custom help type');
    return $actions;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity_type = $this->entity;

    $entity_type->set('id', trim($entity_type->id()));
    $entity_type->set('label', trim($entity_type->label()));

    $status = $entity_type->save();

    $t_args = ['%name' => $entity_type->label()];
    if ($status == SAVED_UPDATED) {
      $message = $this->t('The custom help type %name has been updated.', $t_args);
    }
    elseif ($status == SAVED_NEW) {
      $this->addDefaultDisplaySettings($entity_type);
      $message = $this->t('The custom help type %name has been added.', $t_args);
    }
    $this->messenger()->addStatus($message);

    $form_state->setRedirectUrl($entity_type->toUrl('collection'));
  }

  /**
   * Adds default display settings for new custom help types.
   *
   * @param \Drupal\custom_help\Entity\CustomHelpType $type
   *   The custom help type.
   */
  protected function addDefaultDisplaySettings(CustomHelpType $type) {
    /** @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface $display_repository */
    $display_repository = \Drupal::service('entity_display.repository');

    // Create the inline view mode. Hide all fields but the description.
    $display_repository->getViewDisplay('custom_help', $type->id(), 'inline')
      ->removeComponent('title')
      ->setComponent('body', [
        'label' => 'hidden',
        'type' => 'text_summary_or_trimmed',
      ])
      ->setComponent('more_link', [])
      ->removeComponent('uid')
      ->removeComponent('created')
      ->save();
  }

}
