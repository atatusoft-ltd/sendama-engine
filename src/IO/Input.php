<?php

namespace Sendama\Engine\IO;

use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Enumerations\KeyCode;

/**
 * Class Input. This class is a facade for the InputManager class.
 *
 * @package Sendama\Engine\IO
 */
class Input
{
  /**
   * Returns the value of the virtual axis identified by axisName.
   *
   * @param AxisName $axisName
   * @return float
   */
  public static function getAxis(AxisName $axisName): float
  {
    return InputManager::getAxis($axisName);
  }

  public static function isKeyPressed(KeyCode $keyCode): bool
  {
    return InputManager::isKeyPressed($keyCode);
  }

  /**
   * Checks if all the given keys are pressed.
   *
   * @param array<KeyCode> $keyCodes The key codes to check.
   * @return bool Returns true if any key is pressed, false otherwise.
   */
  public static function areAllKeysPressed(array $keyCodes): bool
  {
    return InputManager::areAllKeysPressed($keyCodes);
  }

  /**
   * Checks if any of the given keys are pressed.
   *
   * @param array<KeyCode> $keyCodes
   * @return bool Returns true if any key is pressed, false otherwise.
   */
  public static function isAnyKeyPressed(array $keyCodes): bool
  {
    return InputManager::isAnyKeyPressed($keyCodes);
  }

  public static function isAnyKeyReleased(array $keyCodes): bool
  {
    return InputManager::isAnyKeyReleased($keyCodes);
  }

  public static function isKeyDown(KeyCode $keyCode): bool
  {
    return InputManager::isKeyDown($keyCode);
  }

  public static function isKeyUp(KeyCode $keyCode): bool
  {
    return InputManager::isKeyUp($keyCode);
  }
}