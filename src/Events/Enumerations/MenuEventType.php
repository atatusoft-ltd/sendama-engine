<?php

namespace Sendama\Engine\Events\Enumerations;

/**
 * An enumeration of menu event types.
 */
enum MenuEventType
{
  case UPDATE;
  case UPDATE_CONTENT;
  case RENDER;
  case ERASE;
  case ITEM_ACTIVATED;
  case ITEM_SELECTED;
  case ITEM_ADDED;
  case ITEM_REMOVED;
  case ITEMS_SET;
  case ITEM_RECEIVED_HORIZONTAL_INPUT;
  case ITEM_RECEIVED_VERTICAL_INPUT;
}
