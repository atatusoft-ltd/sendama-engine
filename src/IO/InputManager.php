<?php

namespace Sendama\Engine\IO;

use RuntimeException;

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
    // TODO: Implement handleInput() method.
  }
}