<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Scenes\Interfaces\SceneInterface;
use Sendama\Engine\Core\Scenes\Interfaces\SceneNodeInterface;
use Sendama\Engine\Debug\Debug;

/**
 * The class SceneNode.
 *
 * @package Sendama\Engine\Core\Scenes
 */
final class SceneNode implements Interfaces\SceneNodeInterface
{
  /**
   * Constructs a SceneNode.
   *
   * @param SceneInterface $scene The scene.
   * @param SceneNodeInterface|null $previousNode The previous node.
   */
  public function __construct(
    protected SceneInterface $scene,
    protected ?SceneNodeInterface $previousNode = null
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
  public function getPreviousNode(): ?SceneNodeInterface
  {
    return $this->previousNode;
  }
}