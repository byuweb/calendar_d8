<?php

namespace Drupal\featured_events\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "featured_events",
 *   admin_label = @Translation("Featured Events block"),
 *   category = @Translation("Featured Events"),
 * )
 */
class HelloBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#markup' => $this->t('Hello, World! Here are some events:'),
        );
    }

}