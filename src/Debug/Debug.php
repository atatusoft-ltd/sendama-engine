<?php

namespace Sendama\Engine\Debug;

use RuntimeException;

class Debug
{
  /**
   * The Debug constructor.
   */
  private function __construct()
  {
  }

  public static function getLogDirectory(): string
  {
    return dirname(__FILE__, 3) . DEFAULT_LOGS_DIR;
  }

  /**
   * Logs a message to the debug log.
   *
   * @param string $message The message to log.
   * @param string $prefix The prefix to add to the message.
   * @throws RuntimeException Thrown if the debug log file cannot be written to.
   */
  public static function log(string $message, string $prefix = '[DEBUG]'): void
  {
    $filename = self::getLogDirectory() . '/debug.log';

    if (!file_exists($filename))
    {
      $file = fopen($filename, 'w');
      fclose($file);
    }

    $message = sprintf("[%s] %s - %s", date('Y-m-d H:i:s'), $prefix, $message) . PHP_EOL;
    if (false === error_log($message, 3, $filename))
    {
      throw new RuntimeException("Failed to write to the debug log.");
    }
  }

  /**
   * Logs an error message to the error log.
   *
   * @param string $message The message to log.
   * @param string $prefix The prefix to add to the message.
   * @throws RuntimeException Thrown if the error log file cannot be written to.
   */
  public static function error(string $message, string $prefix = '[ERROR]'): void
  {
    $filename = self::getLogDirectory() . '/error.log';

    if (!file_exists($filename))
    {
      $file = fopen($filename, 'w');
      fclose($file);
    }

    $message = sprintf("[%s] %s - %s", date('Y-m-d H:i:s'), $prefix, $message) . PHP_EOL;
    if (false === error_log($message, 3, $filename))
    {
      throw new RuntimeException("Failed to write to the debug log.");
    }
  }

  /**
   * Logs a warning message to the warning log.
   *
   * @param string $message The message to log.
   * @param string $prefix The prefix to add to the message.
   * @throws RuntimeException Thrown if the warning log file cannot be written to.
   */
  public static function warn(string $message, string $prefix = '[WARN]'): void
  {
    self::log($message, '[WARN]');
  }

  /**
   * Logs an info message to the info log.
   *
   * @param string $message The message to log.
   * @param string $prefix The prefix to add to the message.
   * @throws RuntimeException Thrown if the info log file cannot be written to.
   */
  public static function info(string $message, string $prefix = '[INFO]'): void
  {
    self::log($message, '[INFO]');
  }
}