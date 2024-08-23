<?php

namespace Sendama\Engine\UI\Modals\Interfaces;

/**
 * The HelpfulInterface interface defines the methods that a class must implement to provide help text.
 *
 * @package Sendama\Engine\UI\Modals\Interfaces
 */
interface HelpfulInterface
{
  /**
   * Returns the help text.
   *
   * @return string The help text.
   */
  public function getHelp(): string;

  /**
   * Sets the help text.
   *
   * @param string $help The help text.
   */
  public function setHelp(string $help): void;

  /**
   * Returns the length of the help text.
   *
   * @return int The length of the help text.
   */
  public function getHelpLength(): int;
}