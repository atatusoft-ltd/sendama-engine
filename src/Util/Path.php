<?php

namespace Sendama\Engine\Util;

use Sendama\Engine\Exceptions\UtilityException;

/**
 * Path is a static class that provides path functionality.
 */
final class Path
{
  /**
   * @var string $workingDirectory The working directory.
   */
  private static string $workingDirectory = '';
  /**
   * @var string $gameFileDirectory The game file directory.
   */
  private static string $gameFileDirectory = '';

  /**
   * Path constructor.
   */
  private function __construct() { }

  /**
   * Joins the given paths.
   *
   * @param string ...$paths The paths to join.
   * @return string
   */
  public static function join(string ...$paths): string
  {
    $result = '';

    foreach ($paths as $path)
    {
      $result .= $path . DIRECTORY_SEPARATOR;
    }

    return rtrim($result, DIRECTORY_SEPARATOR);
  }

  /**
   * Returns the path to the resources' directory.
   *
   * @param string $path The path to the resource.
   * @return string The path to the resource.
   */
  public static function getResourcePath(string $path = ''): string
  {
    if ($path)
    {
      return self::join(self::getProjectRootPath(), 'res', $path);
    }

    return self::join(self::getProjectRootPath(), 'res');
  }

  /**
   * Returns the path to the project's root directory.
   *
   * @return string The path to the project's root directory.
   */
  public static function getProjectRootPath(): string
  {
    return dirname(__DIR__, 2);
  }

  /**
   * Sets the working directory and game file directory.
   *
   * @param false|string $currentWorkingDirectory The current working directory.
   * @param string $gameFileDirectory The game file directory.
   * @return void
   * @throws UtilityException
   */
  public static function init(false|string $currentWorkingDirectory, string $gameFileDirectory): void
  {
    if ($currentWorkingDirectory === false)
    {
      throw new UtilityException('Unable to get current working directory.');
    }

    self::$workingDirectory = $currentWorkingDirectory;
    self::$gameFileDirectory = $gameFileDirectory;
  }

  /**
   * Returns the working directory.
   *
   * @return string The working directory.
   */
  public static function getWorkingDirectory(): string
  {
    return self::$workingDirectory;
  }

  /**
   * Returns the game file directory.
   *
   * @return string The game file directory.
   */
  public static function getGameFileDirectory(): string
  {
    return self::$gameFileDirectory;
  }
}