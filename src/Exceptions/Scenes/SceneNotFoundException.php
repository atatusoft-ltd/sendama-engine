<?php

namespace Sendama\Engine\Exceptions\Scenes;

use Sendama\Engine\Exceptions\GameException;

/**
 * Class SceneNotFoundException. Thrown when a scene is not found.
 *
 * @package Sendama\Engine\Exceptions\Scenes
 */
class SceneNotFoundException extends GameException
{
  /**
   * SceneNotFoundException constructor.
   *
   * @param string $sceneName The name of the scene that was not found.
   */
  public function __construct(string $sceneName)
  {
    parent::__construct("Scene not found: $sceneName");
  }
}