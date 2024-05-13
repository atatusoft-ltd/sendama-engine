<?php

namespace Sendama\Engine\UI\Menus\Attributes;

use Attribute;

/**
 * Class AsMenuItem. Represents a menu item.
 *
 * @package Sendama\Engine\UI\Menus\Attributes
 */
#[Attribute(Attribute::TARGET_METHOD)]
class AsMenuItem
{
  /**
   * AsMenuItem constructor.
   *
   * @param string $name The name of the menu item
   * @param string $description The description of the menu item
   * @param string $icon The icon of the menu item
   */
  public function __construct(
    public string $name,
    public string $description,
    public string $icon,
  )
  {
  }
}