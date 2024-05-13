<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
use Sendama\Engine\Core\Scenes\Interfaces\SceneNodeInterface;

/**
 * The class SceneNode.
 *
 * @package Sendama\Engine\Core\Scenes
 */
final class SceneNode implements Interfaces\SceneNodeInterface
{
  public function __construct(
    protected SceneInterface $scene,
    protected ?SceneInterface $previousScene = null
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function getScene(): SceneInterface
  {
    return $this->scene;
  }

  /**
   * @inheritDoc
   */
  public function getPreviousScene(): ?SceneInterface
  {
    return $this->previousScene;
  }
}