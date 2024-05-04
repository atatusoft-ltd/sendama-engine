<?php

namespace Sendama\Engine\Core\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Serializable;

/**
 * The interface for all components in the game engine.
 *
 * @template T
 */
interface ComponentInterface extends
  ActivatableInterface,
  CanResume,
  CanUpdate,
  CanStart,
  CanCompare,
  CanEnable,
  CanAwake,
  Serializable
{
  /**
   * Returns the GameObject that this component is attached to.
   *
   * @return GameObject The GameObject that this component is attached to.
   */
  public function getGameObject(): GameObject;

  /**
   * Returns the Transform of the GameObject that this component is attached to.
   *
   * @return Transform The Transform of the GameObject that this component is attached to.
   */
  public function getTransform(): Transform;

  /**
   * Calls the method named $methodName on every component in this game object and its children.
   *
   * @param string $methodName The name of the method to call.
   * @param array<string, mixed> $args The arguments to pass to the method.
   * @return void
   */
  public function broadcast(string $methodName, array $args = []): void;

  /**
   * Checks the GameObject's tag against the defined tag.
   *
   * @param string $tag The tag to check.
   * @return bool True if the GameObject has the tag, false otherwise.
   */
  public function hasTag(string $tag): bool;
}