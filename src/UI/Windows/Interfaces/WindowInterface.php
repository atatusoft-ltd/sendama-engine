<?php

namespace Sendama\Engine\UI\Windows\Interfaces;

use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Events\Interfaces\SubjectInterface;
use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\UI\Windows\WindowAlignment;

interface WindowInterface extends CanRender, SubjectInterface
{
  /**
   * Returns the window's title.
   *
   * @return string The window's title.
   */
  public function getTitle(): string;

  /**
   * Sets the window's title.
   *
   * @param string $title The window's title.
   * @return void
   */
  public function setTitle(string $title): void;

  /**
   * Returns the window's help message.
   *
   * @return string The window's help message.
   */
  public function getHelp(): string;

  /**
   * Sets the window's help message.
   *
   * @param string $help The help message.
   * @return void
   */
  public function setHelp(string $help): void;

  /**
   * Sets the window's position.
   *
   * @param Vector2|array{x: int, y: int} $position The window's position.
   * @return void
   */
  public function setPosition(Vector2|array $position): void;

  /**
   * Returns the window's position.
   *
   * @return Vector2 The window's position.
   */
  public function getPosition(): Vector2;

  /**
   * Returns the border pack of the window. This pack determines the window's border.
   *
   * @return BorderPackInterface The window's border pack.
   */
  public function getBorderPack(): BorderPackInterface;

  /**
   * Sets the border pack of the window. This pack determines the window's border.
   *
   * @param BorderPackInterface $borderPack The window's border pack.
   * @return void
   */
  public function setBorderPack(BorderPackInterface $borderPack): void;

  /**
   * Returns the window's alignment.
   *
   * @return WindowAlignment The window's alignment.
   */
  public function getAlignment(): WindowAlignment;

  /**
   * Sets the window's alignment.
   *
   * @param WindowAlignment $alignment The window's alignment.
   * @return void
   */
  public function setAlignment(WindowAlignment $alignment): void;

  /**
   * Returns the background color.
   *
   * @return Color The background color.
   */
  public function getBackgroundColor(): Color;

  /**
   * Sets the background color of the window.
   *
   * @param Color $backgroundColor The background color.
   * @return void
   */
  public function setBackgroundColor(Color $backgroundColor): void;

  /**
   * Returns the foreground color.
   *
   * @return Color|null The foreground color.
   */
  public function getForegroundColor(): ?Color;

  /**
   * Sets the foreground color.
   *
   * @param Color $color The foreground color.
   * @return void
   */
  public function setForegroundColor(Color $color): void;

  /**
   * Returns the content of the window.
   *
   * @return string[] The content of the window.
   */
  public function getContent(): array;

  /**
   * Sets the content of the window.
   *
   * @param string[] $content The content of the window.
   * @return void
   */
  public function setContent(array $content): void;
}