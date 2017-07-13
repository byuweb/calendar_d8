<?php

namespace Drupal\calendar_widget_d8\Controller;

use Drupal\examples\Utility\DescriptionTemplateTrait;
/**
 * Controller routines for block example routes.
 */
class BlockExampleController {
  use DescriptionTemplateTrait;

  /**
   * {@inheritdoc}
   */
  protected function getModuleName() {
    return 'calendar_widget_d8';
  }

}
