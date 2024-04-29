<?php

namespace Sendama\Engine\Debug\Enumerations;

/**
 * LogLevel enumeration
 */
enum LogLevel: string
{
  case DEBUG = 'debug';
  case INFO = 'info';
  case WARN = 'warn';
  case ERROR = 'error';
  case FATAL = 'fatal';

  /**
   * Returns the priority of the log level.
   *
   * @return int The priority of the log level.
   */
  public function getPriority(): int
  {
    return match ($this) {
      LogLevel::FATAL => 0,
      LogLevel::ERROR => 1,
      LogLevel::WARN => 2,
      LogLevel::DEBUG => 3,
      LogLevel::INFO => 4,
    };
  }
}
