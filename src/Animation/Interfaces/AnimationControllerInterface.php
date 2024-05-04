<?php

namespace Sendama\Engine\Animation\Interfaces;

/**
 * Represents an animation controller that can play, pause, resume, and stop animation clips.
 *
 * @package Sendama\Engine\Animation\Interfaces
 */
interface AnimationControllerInterface extends AnimationControllerStateInterface
{
  /**
   * Set the state of the animation controller.
   *
   * @param AnimationControllerStateInterface $state The state of the animation controller.
   */
  public function setState(AnimationControllerStateInterface $state): void;

  /**
   * Get the state of the animation controller.
   *
   * @return AnimationControllerStateInterface The state of the animation controller.
   */
  public function getState(): AnimationControllerStateInterface;

  /**
   * Get the speed of the animation controller.
   *
   * @return float The speed of the animation controller.
   */
  public function getSpeed(): float;

  /**
   * Set the speed of the animation controller.
   *
   * @param float $speed The speed of the animation controller.
   */
  public function setSpeed(float $speed): void;

  /**
   * Get the time of the animation controller.
   *
   * @return int|float The time of the animation controller.
   */
  public function getTime(): int|float;

  /**
   * Load a clip into the animation controller. This will set the current clip to the clip with the given name.
   *
   * @param string $name The name of the clip to load.
   * @return void
   */
  public function loadClip(string $name): void;

  /**
   * Add a clip to the animation controller.
   *
   * @param AnimationClipInterface $clip The clip to add.
   * @return void
   */
  public function addClip(AnimationClipInterface $clip): void;

  /**
   * Remove a clip from the animation controller.
   *
   * @param string $name The name of the clip to remove.
   * @return void
   */
  public function removeClip(string $name): void;

  /**
   * Returns the total number of clips in the animation controller.
   *
   * @return int The total number of clips in the animation controller.
   */
  public function getTotalClips(): int;

  /**
   * Returns the index of the current clip in the animation controller.
   *
   * @return int The index of the current clip in the animation controller.
   */
  public function getCurrentClipIndex(): int;

  /**
   * Returns the current clip in the animation controller.
   *
   * @return AnimationClipInterface|null The current clip in the animation controller or null if there is no current clip.
   */
  public function getCurrentClip(): ?AnimationClipInterface;
}