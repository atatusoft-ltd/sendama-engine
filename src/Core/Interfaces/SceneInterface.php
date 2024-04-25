<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * The interface SceneInterface.
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
   * @return array
   */
  public function getRootGameObjects(): array;
}