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
}
