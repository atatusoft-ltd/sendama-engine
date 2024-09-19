<?php

namespace Sendama\Engine\Events\Enumerations;

/**
 * Class MapEventType. Represents a map event type.
 *
 * @package Sendama\Engine\Events\Enumerations
 */
enum MapEventType
{
  case LOAD;
  case UNLOAD;
  case START;
  case STOP;
  case UPDATE;
  case SUSPEND;
  case RESUME;
}
