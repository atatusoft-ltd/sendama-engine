<?php

namespace Sendama\Engine\Events\Enumerations;

/**
 * GameEventType is an enumeration of all game event types.
 */
enum GameEventType: string
{
  case START = 'start';
  case STOP = 'stop';
  case PAUSE = 'pause';
  case RESUME = 'resume';
  case UPDATE = 'update';
  case RENDER = 'render';
  case SUSPEND = 'suspend';
  case QUIT = 'quit';
}
