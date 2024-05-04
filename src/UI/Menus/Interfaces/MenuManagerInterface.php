<?php

namespace Sendama\Engine\UI\Menus\Interfaces;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\UI\Interfaces\CanFocus;

/**
 * Interface MenuManagerInterface. Represents a menu manager.
 *
 * @package Sendama\Engine\UI\Menus\Interfaces
 */
interface MenuManagerInterface extends CanUpdate, CanRender, CanFocus
{
  /**
   * Determines if the menu is focused.
   *
   * @param MenuGraphNodeInterface $target The target node.
   * @return bool
   */
  public function isFocused(MenuGraphNodeInterface $target): bool;

  /**
   * Returns the focused node.
   *
   * @return MenuGraphNodeInterface|null The focused node.
   */
  public function getFocused(): MenuGraphNodeInterface|null;
}