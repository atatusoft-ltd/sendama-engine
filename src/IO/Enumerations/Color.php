<?php

namespace Sendama\Engine\IO\Enumerations;

/**
 * Represents a color.
 *
 * @package Sendama\Engine\IO\Enumerations
 */
enum Color: string
{
  case BLACK = "\033[0;30m";
  case DARK_GRAY = "\033[1;30m";
  case BLUE = "\033[0;34m";
  case LIGHT_BLUE = "\033[1;34m";
  case GREEN = "\033[0;32m";
  case LIGHT_GREEN = "\033[1;32m";
  case CYAN = "\033[0;36m";
  case LIGHT_CYAN = "\033[1;36m";
  case RED = "\033[0;31m";
  case LIGHT_RED = "\033[1;31m";
  case PURPLE = "\033[0;35m";
  case LIGHT_PURPLE = "\033[1;35m";
  case BROWN = "\033[0;33m";
  case YELLOW = "\033[1;33m";
  case LIGHT_GRAY = "\033[0;37m";
  case WHITE = "\033[1;37m";
  case RESET = "\033[0m";

  /**
   * Applies the color to the given string.
   *
   * @param Color $color The color to apply.
   * @param string $to The string to apply the color to.
   * @return string
   */
  public static function apply(Color $color, string $to): string
  {
    return $color->value . $to . Color::RESET->value;
  }

  public function getPhoneticName(): string
  {
    return match ($this) {
      Color::BLACK => 'Black',
      Color::DARK_GRAY => 'Dark Gray',
      Color::BLUE => 'Blue',
      Color::LIGHT_BLUE => 'Light Blue',
      Color::GREEN => 'Green',
      Color::LIGHT_GREEN => 'Light Green',
      Color::CYAN => 'Cyan',
      Color::LIGHT_CYAN => 'Light Cyan',
      Color::RED => 'Red',
      Color::LIGHT_RED => 'Light Red',
      Color::PURPLE => 'Purple',
      Color::LIGHT_PURPLE => 'Light Purple',
      Color::BROWN => 'Brown',
      Color::YELLOW => 'Yellow',
      Color::LIGHT_GRAY => 'Light Gray',
      Color::WHITE => 'White',
      Color::RESET => 'Reset',
    };
  }
}
