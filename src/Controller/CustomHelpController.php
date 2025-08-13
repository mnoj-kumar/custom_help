<?php

namespace Drupal\custom_help\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Custom Help routes.
 */
class CustomHelpController extends ControllerBase {

  /**
   * Redirects the standard module help page to the custom help admin overview.
   */
  public function helpPageRedirection() {
    return $this->redirect('custom_help.admin');
  }

}
