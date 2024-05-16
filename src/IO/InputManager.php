<?php

namespace Sendama\Engine\IO;

use RuntimeException;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Events\EventManager;
use Sendama\Engine\Events\KeyboardEvent;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Enumerations\KeyCode;

/**
 * InputManager handles input from the user.
 */
class InputManager
{
  /**
   * The previous key press.
   *
   * @var string
   */
  private static string $previousKeyPress = '';

  /**
   * The current key press.
   *
   * @var string
   */
  private static string $keyPress = '';

  /**
   * The virtual axes.
   *
   * @var VirtualAxis[] $axes The virtual axes.
   */
  private static array $axes = [];

  /**
   * The button map.
   *
   * @var array<Button> $buttons The button map.
   */
  private static array $buttons = [];

  /**
   * Initializes the InputManager.
   *
   * @return void
   */
  public static function init(): void
  {
    self::$previousKeyPress = self::$keyPress = '';
  }

  /**
   * Enables non-blocking mode.
   *
   * @return void
   * @throws RuntimeException Thrown if non-blocking mode could not be enabled.
   */
  public static function enableNonBlockingMode(): void
  {
    if (false === stream_set_blocking(STDIN, false))
    {
      throw new RuntimeException('Failed to enable non-blocking mode.');
    }
  }

  /**
   * Disables non-blocking mode.
   *
   * @return void
   * @throws RuntimeException Thrown if non-blocking mode could not be disabled.
   */
  public static function disableNonBlockingMode(): void
  {
    if (false === stream_set_blocking(STDIN, true))
    {
      throw new RuntimeException('Failed to disable non-blocking mode.');
    }
  }

  public static function disableEcho(): void
  {
    system('stty cbreak -echo');
  }

  public static function enableEcho(): void
  {
    system('tput reset');

    // Turn on cursor blinking
    echo "\033[?12l";
    system('stty -cbreak echo');
  }

  /**
   * Handles input.
   *
   * @return void
   */
  public static function handleInput(): void
  {
    self::$previousKeyPress = self::$keyPress;
    self::$keyPress = fgets(STDIN);

    if (false === self::$keyPress)
    {
      throw new RuntimeException('Failed to read input.');
    }

    if (self::$keyPress)
    {
      EventManager::getInstance()->dispatchEvent(event: new KeyboardEvent(key: self::getKey(keyPress: self::$keyPress)));
    }
  }

  /**
   * Returns the value of the virtual axis identified by axisName.
   *
   * @param AxisName|string $axisName The name of the axis.
   * @return float Returns the value of the virtual axis identified by axisName.
   */
  public static function getAxis(AxisName|string $axisName): float
  {
    if (is_string($axisName))
    {
      /** @var ?Button $axis */
      $axis = array_filter(self::$buttons, fn(Button $button) => $button->getName() === $axisName)[0] ?? null;
      if (is_null($axis))
      {
        return 0;
      }

      return $axis->getValue();
    }

    if ($axisName === AxisName::HORIZONTAL)
    {
      if (self::isAnyKeyPressed([KeyCode::LEFT, KeyCode::A, KeyCode::a]))
      {
        return -1;
      }
      else if (self::isAnyKeyPressed([KeyCode::RIGHT, KeyCode::D, KeyCode::d]))
      {
        return 1;
      }
    }
    else if ($axisName === AxisName::VERTICAL)
    {
      if (self::isAnyKeyPressed([KeyCode::UP, KeyCode::W, KeyCode::w]))
      {
        return -1;
      }
      else if (self::isAnyKeyPressed([KeyCode::DOWN, KeyCode::S, KeyCode::s]))
      {
        return 1;
      }
    }

    return 0;
  }

  /**
   * Checks if a key is pressed.
   *
   * @param KeyCode $keyCode The key code to check.
   * @return bool Returns true if the key is pressed, false otherwise.
   */
  public static function isKeyPressed(KeyCode $keyCode): bool
  {
    return self::$keyPress === $keyCode->value;
  }

  /**
   * Checks if all keys are pressed.
   *
   * @param array $keyCodes The key codes to check.
   * @return bool Returns true if all keys are pressed, false otherwise.
   */
  public static function areAllKeysPressed(array $keyCodes): bool
  {
    foreach ($keyCodes as $keyCode)
    {
      if (!self::isKeyPressed($keyCode))
      {
        return false;
      }
    }
    return true;
  }

  /**
   * Checks if any key is pressed.
   *
   * @param KeyCode[] $keyCodes The key codes to check.
   * @return bool Returns true if any key is pressed, false otherwise.
   */
  public static function isAnyKeyPressed(array $keyCodes): bool
  {
    foreach ($keyCodes as $keyCode)
    {
      if (self::isKeyDown($keyCode))
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Checks if any of the given key codes was released.
   *
   * @param KeyCode[] $keyCodes The key codes to check.
   * @return bool Returns true if any key is released, false otherwise.
   */
  public static function isAnyKeyReleased(array $keyCodes): bool
  {
    foreach ($keyCodes as $keyCode)
    {
      if (self::isKeyUp($keyCode))
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Checks if a key is pressed down.
   *
   * @param KeyCode $keyCode The key code to check.
   * @return bool Returns true if the key is pressed down, false otherwise.
   */
  public static function isKeyDown(KeyCode $keyCode): bool
  {
    $key = self::getKey(self::$keyPress);
    $previousKey = self::getKey(self::$previousKeyPress);

    return $key === $keyCode->value && $previousKey !== $key;
  }

  /**
   * Checks if a key is released.
   *
   * @param KeyCode $keyCode The key code to check.
   * @return bool Returns true if the key is released, false otherwise.
   */
  public static function isKeyUp(KeyCode $keyCode): bool
  {
    $key = self::getKey(self::$keyPress);
    $previousKey = self::getKey(self::$previousKeyPress);

    return empty($key) && $previousKey === $keyCode->value;
  }

  /**
   * Checks if a button of given name $buttonName is down.
   *
   * @param string $buttonName The name of the button.
   * @return bool Returns true if the button is down, false otherwise.
   */
  public static function isButtonDown(string $buttonName): bool
  {
    foreach (self::$buttons as $button)
    {
      if ($button->getName() === $buttonName)
      {
        return self::isAnyKeyPressed($button->getPositiveKeys());
      }
    }

    return false;
  }

  /**
   * Adds an axis.
   *
   * @param VirtualAxis ...$axes The axis to add.
   * @return void
   */
  public static function addAxes(VirtualAxis ...$axes): void
  {
    foreach ($axes as $axis)
    {
      self::$axes[] = $axis;
    }
  }

  /**
   * Finds an axis by name.
   *
   * @param string $axisName The name of the axis.
   * @return VirtualAxis|null Returns the axis if found, null otherwise.
   */
  private static function findAxis(string $axisName): ?VirtualAxis
  {
    return array_filter(self::$axes, fn($axis) => $axis->getName() === $axisName)[0] ?? null;
  }

  /**
   * Translates a key press to a string.
   *
   * @param string|null $keyPress The key press to translate.
   * @return string Returns the translated key press.
   */
  private static function getKey(?string $keyPress): string
  {
    if (is_null($keyPress))
    {
      return '';
    }

    return match($keyPress) {
      "\033[A"  => KeyCode::UP->value,
      "\033[B"  => KeyCode::DOWN->value,
      "\033[C"  => KeyCode::RIGHT->value,
      "\033[D"  => KeyCode::LEFT->value,
      "\n"      => KeyCode::ENTER->value,
      " "       => KeyCode::SPACE->value,
      "\010",
      "\177"    => KeyCode::BACKSPACE->value,
      "\t"      => KeyCode::TAB->value,
      "\033",
      "\e"      => KeyCode::ESCAPE->value,
      "\033[1~",
      "\033[7~" => KeyCode::HOME->value,
      "\033[2~" => KeyCode::INSERT->value,
      "\033[3~" => KeyCode::DELETE->value,
      "\033[8",
      "\033[4~" => KeyCode::END->value,
      "\033[5~" => KeyCode::PAGE_UP->value,
      "\033[6~" => KeyCode::PAGE_DOWN->value,
      "\033[10~"  => KeyCode::F0->value,
      "\033[11~"  => KeyCode::F1->value,
      "\033[12~"  => KeyCode::F2->value,
      "\033[13~"  => KeyCode::F3->value,
      "\033[14~"  => KeyCode::F4->value,
      "\033[15~"  => KeyCode::F5->value,
      "\033[17~"  => KeyCode::F6->value,
      "\033[18~"  => KeyCode::F7->value,
      "\033[19~"  => KeyCode::F8->value,
      "\033[20~"  => KeyCode::F9->value,
      "\033[21~"  => KeyCode::F10->value,
      "\033[23~"  => KeyCode::F11->value,
      "\033[24~"  => KeyCode::F12->value,
      default   => $keyPress
    };
  }
}