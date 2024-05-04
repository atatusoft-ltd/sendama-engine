<?php

namespace Sendama\Engine\Animation\Enumerations;

/**
 * Enumerates the different wrap modes that an animation clip can have.
 */
enum WrapMode
{
  /**
   * The animation clip will play once and then stop.
   */
  case ONCE;
  /**
   * The animation clip will loop indefinitely.
   */
  case LOOP;
  /**
   * The animation clip will ping-pong back and forth indefinitely.
   */
  case PING_PONG;
  /**
   * The animation clip will clamp to the last frame after it has played once.
   */
  case CLAMP_FOREVER;
}
