<?php

namespace Sendama\Engine\Animation\Interfaces;

/**
 * Interface AnimationControllerStateInterface
 *
 * @package Sendama\Engine\Animation\Interfaces
 */
interface AnimationControllerStateInterface
{
  /**
   * Play the current clip.
   *
   * @return void
   */
  public function playClip(): void;

  /**
   * Pause the currently playing clip.
   *
   * @return void
   */
  public function pauseClip(): void;

  /**
   * Resume the currently paused clip.
   *
   * @return void
   */
  public function resumeClip(): void;

  /**
   * Stop the currently playing clip.
   *
   * @return void
   */
  public function stopClip(): void;
}