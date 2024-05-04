<?php

namespace Sendama\Engine\UI\Interfaces;

use Sendama\Engine\Events\Interfaces\EventInterface;

/**
 * Interface FocusTargetInterface
 *
 * This interface is used to define an element that can be focused.
 *
 * @package Sendama\Engine\UI\Interfaces
 */
interface FocusTargetInterface
{
  /**
   * Called when the element is focused.
   *
   * @param EventInterface $event
   * @return void
   */
  public function onFocus(EventInterface $event): void;

  /**
   * Called when the element is blurred.
   *
   * @param EventInterface $event
   * @return void
   */
  public function onBlur(EventInterface $event): void;
}