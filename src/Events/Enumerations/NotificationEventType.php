<?php

namespace Sendama\Engine\Events\Enumerations;

/**
 * Class NotificationEventType. Represents a notification event type.
 *
 * @package Sendama\Engine\Events\Enumerations
 */
enum NotificationEventType
{
  case OPEN;
  case DISMISS;
  case UPDATE;
  case RENDER;
  case ERASE;
  case RESUME;
  case SUSPEND;
}
