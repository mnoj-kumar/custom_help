<?php

namespace Drupal\custom_help\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the custom help entity edit forms.
 */
class CustomHelpForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $result = $entity->save();
    $entity_link = $entity->toLink($this->t('View'))->toString();
    $entity_type = $entity->bundle->entity;
    $logger_arguments = ['@type' => $entity_type->id(), '%title' => $entity->label(), 'link' => $entity_link];
    $message_arguments = ['@type' => $entity_type->label(), '%title' => $entity->toLink()->toString()];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New custom help %label has been created.', $message_arguments));
      $this->logger('custom_help')->notice('Created new custom help %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The custom help %label has been updated.', $message_arguments));
      $this->logger('custom_help')->notice('Updated new custom help %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.custom_help.canonical', ['custom_help' => $entity->id()]);
  }

}
