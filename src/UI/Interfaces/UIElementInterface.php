<?php

namespace Sendama\Engine\UI\Interfaces;

use Sendama\Engine\Core\Interfaces\CanActivate;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\UI\UIElement;

/**
 * Interface UIElementInterface. Represents a UI element.
 *
 * @package Sendama\Engine\UI\Interfaces
 */
interface UIElementInterface extends CanUpdate, CanRender, CanStart, CanResume, CanActivate
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

  /**
   * Finds a UI element by its name.
   *
   * @param string $uiElementName The name of the UI element.
   * @return UIElementInterface|null The UI element if found, null otherwise.
   */
  public static function find(string $uiElementName): ?self;

  /**
   * Finds all UI elements by their name.
   *
   * @param string $uiElementName The name of the UI element.
   * @return UIElementInterface[] The UI elements if found, an empty array otherwise.
   */
  public static function findAll(string $uiElementName): array;
}