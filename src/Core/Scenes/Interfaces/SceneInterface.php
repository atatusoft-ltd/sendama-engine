<?php

namespace Sendama\Engine\Core\Scenes\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Grid;
use Sendama\Engine\Core\Interfaces\CanAwake;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;
use Sendama\Engine\Core\Interfaces\GameObjectInterface;
use Sendama\Engine\Core\Rendering\Interfaces\CameraInterface;
use Sendama\Engine\UI\Interfaces\UIElementInterface;
use Serializable;

/**
 * The interface SceneInterface.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface SceneInterface extends CanStart, CanUpdate, CanRender, CanResume, CanAwake, Serializable
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
   * @return array<GameObjectInterface> The list of root game objects in the scene.
   */
  public function getRootGameObjects(): array;

  /**
   * Returns the UI elements.
   *
   * @return array<UIElementInterface> The list of UI elements in the scene.
   */
  public function getUIElements(): array;

  /**
   * Adds a game object or UI element to the scene.
   *
   * @param GameObjectInterface|UIElementInterface $object The game object or UI element to add.
   * @return void
   */
  public function add(GameObjectInterface|UIElementInterface $object): void;

  /**
   * Removes a game object from the scene.
   *
   * @param GameObjectInterface|UIElementInterface $object The game object to remove.
   * @return void
   */
  public function remove(GameObjectInterface|UIElementInterface $object): void;

  /**
   * Returns the camera.
   *
   * @return CameraInterface The camera.
   */
  public function getCamera(): CameraInterface;

  /**
   * Returns the scene's workspace grid.
   *
   * @return Grid The workspace grid.
   */
  public function getWorldSpace(): Grid;

  /**
   * Returns the scene's settings.
   *
   * @param string|null $key The key of the setting to retrieve. If null, all settings are returned.
   * @return mixed The setting value.
   */
  public function getSettings(?string $key): mixed;
}