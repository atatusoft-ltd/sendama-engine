<?php

namespace Sendama\Engine\UI\Menus\Attributes;

use Attribute;

/**
 * Class AsMenu. Represents a menu.
 *
 * @package Sendama\Engine\UI\Menus\Attributes
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class AsMenu
{
  /**
   * AsMenu constructor.
   *
   * @param string $name The name of the menu
   * @param string $description The description of the menu
   * @param string $icon The icon of the menu
   */
  public function __construct(
    public string $name,
    public string $description,
    public string $icon,
  )
  {
  }
}