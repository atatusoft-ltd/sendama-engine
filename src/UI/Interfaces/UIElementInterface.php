<?php

namespace Sendama\Engine\UI\Interfaces;

use Sendama\Engine\Core\Interfaces\CanEnable;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;

/**
 * Interface UIElementInterface. Represents a UI element.
 *
 * @package Sendama\Engine\UI\Interfaces
 */
interface UIElementInterface extends CanUpdate, CanRender, CanStart, CanResume, CanEnable
{
  /**
   * Gets the name of the UI element.
   *
   * @return string
   */
  public function getName(): string;

  /**
   * Sets the name of the UI element.
   *
   * @param string $name The name of the UI element.
   */
  public function setName(string $name): void;
}