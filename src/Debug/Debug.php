<?php

namespace Sendama\Engine\Debug;

use RuntimeException;
use Sendama\Engine\Debug\Enumerations\LogLevel;
use Sendama\Engine\Util\Path;

class Debug
{
  private static ?string $logDirectory = null;
  private static LogLevel $logLevel = LogLevel::DEBUG;

  /**
   * The Debug constructor.
   */
  private function __construct()
  {
  }

  /**
   * @param string $logDirectory
   * @return void
   */
  public static function setLogDirectory(string $logDirectory): void
  {
    self::$logDirectory = $logDirectory;
  }

  /**
   * Returns the log directory.
   *
   * @return string The log directory.
   */
  public static function getLogDirectory(): string
  {
    if (self::$logDirectory === null)
    {
      self::$logDirectory = Path::join(dirname(__FILE__, 3), DEFAULT_LOGS_DIR);
    }

    return self::$logDirectory;
  }

  /**
   * Sets the log level.
   *
   * @param LogLevel $level The log level to set.
   * @return void
   */
  public static function setLogLevel(LogLevel $level): void
  {
    self::$logLevel = $level;
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
    $filename = Path::join(self::getLogDirectory(),  'debug.log');

    if (!file_exists($filename))
    {
      if (!is_writeable(self::getLogDirectory()))
      {
        throw new RuntimeException("The directory, " . self::getLogDirectory() . ", is not writable.");
      }

      if (false === $file = fopen($filename, 'w'))
      {
        throw new RuntimeException("Failed to create the debug log file.");
      }
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
    if (self::$logLevel !== LogLevel::ERROR && self::$logLevel !== LogLevel::FATAL)
    {
      return;
    }

    $filename = Path::join(self::getLogDirectory(),  'error.log');

    if (!file_exists($filename))
    {
      if (!is_writeable(self::getLogDirectory()))
      {
        throw new RuntimeException("The directory, " . self::getLogDirectory() . ", is not writable.");
      }

      if (false === $file = fopen($filename, 'w'))
      {
        throw new RuntimeException("Failed to create the error log file.");
      }

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