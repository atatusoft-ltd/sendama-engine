<?php

namespace Sendama\Engine;

use Error;
use Exception;
use Throwable;

/**
 * The main Game engine class.
 *
 * @package Sendama\Engine;
 */
class Game
{
  private array $settings = [];

  /**
   * @param string $name The name of the game.
   */
  public function __construct(
    private readonly string $name,
    private readonly int $screenWidth = DEFAULT_SCREEN_WIDTH,
    private readonly int $screenHeight = DEFAULT_SCREEN_HEIGHT,
  )
  {
  }

  public function __destruct()
  {
  }

  /**
   * Load game settings.
   *
   * @param array<string, mixed>|null $settings The settings to load. If null will load default settings.
   * @return $this The current instance of the game engine.
   */
  public function loadSettings(?array $settings = null): self
  {
    // TODO: Load settings
    $this->settings['fps'] = $settings['fps'] ?? DEFAULT_FPS;
    $this->settings['assets_path'] = $settings['assets_path'] ?? getcwd() . DEFAULT_ASSETS_PATH;

    return $this;
  }

  public function run(): void
  {
  }

  public function start(): void
  {
  }

  public function end(): void
  {
  }

  public function handleInput(): void
  {
  }

  public function update(): void
  {
  }

  public function render(): void
  {
  }

  /**
   * Handles game errors.
   *
   * @param int $errno
   * @param string $errstr
   * @param string $errfile
   * @param int $errline
   * @return never
   */
  private function handleError(int $errno, string $errstr, string $errfile, int $errline): never
  {
    $errorMessage = "[$errno] $errstr in $errfile on line $errline";
    // Debug::error($errorMessage):
    exit($errorMessage);
  }


  /**
   * Handle game exceptions.
   *
   * @param Exception|Throwable|Error $exception The exception to be handled.
   * @return never
   */
  private function handleException(Exception|Throwable|Error $exception): never
  {
    $this->errors[] = $exception;
    // Debug::error($exception);
    exit($exception);
  }
}