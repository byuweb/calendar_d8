<?php

namespace Drupal\calendar_d8\Plugin\Block;

use DateTime;
use DateTimeZone;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * Drupal\Core\Block\BlockBase gives us a very useful set of basic functionality
 * for this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "calendar_featured_events",
 *   admin_label = @Translation("Calendar Widget: Featured Events")
 * )
 */
class FeaturedEvents extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'calendar_d8_string' => $this->t('A default value. Katria, This block was created at %time', array('%time' => date('c'))),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
      $form['calendar_d8_category_id'] = array(
          '#type' => 'textfield',
          '#default_value' => theme_get_setting('calendar_d8_category_id'),
          '#description' => 'The Category id of the category for which you wish to display events.',
      );
//    $form['calendar_d8_string_text'] = array(
//      '#type' => 'textarea',
//      '#title' => $this->t('Block contents'),
//      '#description' => $this->t('Katria, This text will appear in the example block.'),
//      '#default_value' => $this->configuration['calendar_d8_string'],
//    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $category = $form_state->getValue('calendar_d8_category_id');
      $this->configuration['calendar_d8_string']
      = $form_state->getValue('calendar_d8_category_id');
//      = calendar_d8_build_display($category);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
//      $category = $form_state->getValue('calendar_d8_category_id');
      $category = '90';
      $html = calendar_d8_build_display($category);
//      $html = calendar_d8_fetch_events($category);
//      $html = 'this is a new test';
      $tz = new DateTimeZone('America/Denver');
      $tomorrow = new DateTime("tomorrow", $tz);
      $now = new DateTime("now", $tz);

    return array(
//        '#type' => 'markup',
        //      '#markup' => $this->configuration['calendar_d8_string'],
//        '#markup' =>  $html,
        '#type' => 'inline_template',
        '#template' => '{{ content | raw }}',
        '#context' => [
          'content' => $html,
        ],
        '#cache' => [
            'max-age' => ($tomorrow->getTimestamp() - $now->getTimestamp()) //i.e. expire cache at midnight tonight
        ],
        '#attached' => array(
            'library' => array(
                'calendar_d8/feature-styles',
            ),
        ),
    );
  }




}
