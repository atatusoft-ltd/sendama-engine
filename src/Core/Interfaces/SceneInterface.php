<?php

namespace Sendama\Engine\Core\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Rendering\Interfaces\CameraInterface;

/**
 * The interface SceneInterface.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface SceneInterface extends CanStart, CanUpdate, CanRender, CanResume
{
  /**
   * @return string The name of the scene.
   */
  public function getName(): string;

  /**
   * Loads the scene settings.
   *
   * @param array|null $settings The scene settings.
   * @return self
   */
  public function loadSceneSettings(?array $settings = null): self;

  /**
   * Starts the scene.
   *
   * @return void
   */
  public function start(): void;

  /**
   * Stops the scene.
   *
   * @return void
   */
  public function stop(): void;

  /**
   * Updates the scene.
   *
   * @return void
   */
  public function update(): void;

  /**
   * Renders the scene.
   *
   * @return void
   */
  public function render(): void;

  /**
   * Erases the scene.
   *
   * @return void
   */
  public function erase(): void;

  /**
   * Suspends the scene.
   *
   * @return void
   */
  public function suspend(): void;

  /**
   * Resumes the scene.
   *
   * @return void
   */
  public function resume(): void;

  /**
   * Returns the root game objects.
   *
   * @return array
   */
  public function getRootGameObjects(): array;

  /**
   * Adds a game object to the scene.
   *
   * @param GameObject $gameObject The game object to add.
   * @return void
   */
  public function add(GameObject $gameObject): void;

  /**
   * Removes a game object from the scene.
   *
   * @param GameObject $gameObject The game object to remove.
   * @return void
   */
  public function remove(GameObject $gameObject): void;

  /**
   * Returns the camera.
   *
   * @return \Sendama\Engine\Core\Rendering\Interfaces\CameraInterface The camera.
   */
  public function getCamera(): \Sendama\Engine\Core\Rendering\Interfaces\CameraInterface;
}