<?php

namespace Sendama\Engine\Events\Enumerations;

/**
 * SceneEventType
 *
 * The type of scene event.
 */
enum SceneEventType
{
  case INIT;
  case START;
  case STOP;
  case LOAD_START;
  case LOAD_END;
  case UNLOAD;
  case RENDER;
  case RENDER_BACKGROUND;
  case RENDER_SPRITES;
  case ERASE;
  case UPDATE;
  case RESUME;
  case SUSPEND;
  case UPDATE_PHYSICS;
}
