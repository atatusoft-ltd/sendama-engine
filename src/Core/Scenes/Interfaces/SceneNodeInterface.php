<?php

namespace Sendama\Engine\Core\Scenes\Interfaces;

/**
 * The interface SceneNodeInterface.
 *
 * @package Sendama\Engine\Core\Scenes\Interfaces
 */
interface SceneNodeInterface
{
  /**
   * Returns the scene.
   *
   * @return SceneInterface The scene.
   */
  public function getScene(): SceneInterface;

  /**
   * Returns the previous scene.
   *
   * @return SceneNodeInterface|null The previous scene.
   */
  public function getPreviousNode(): ?SceneNodeInterface;
}