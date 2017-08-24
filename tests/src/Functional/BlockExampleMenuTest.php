<?php

namespace Drupal\Tests\calendar_d8\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the user-facing menus in Block Example.
 *
 * @ingroup calendar_d8
 *
 * @group calendar_d8
 * @group examples
 */
class BlockExampleMenuTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('block', 'calendar_d8');

  /**
   * The installation profile to use with this test.
   *
   * This test class requires the "Tools" block.
   *
   * @var string
   */
  protected $profile = 'minimal';

  /**
   * Test for a link to the block example in the Tools menu.
   */
  public function testBlockExampleLink() {
    $this->drupalGet('');
    $this->assertLinkByHref('examples/block-example');
  }

  /**
   * Tests calendar_d8 menus.
   */
  public function testBlockExampleMenu() {
    $this->drupalGet('examples/block-example');
    $this->assertResponse(200, 'Description page exists.');
  }

}
