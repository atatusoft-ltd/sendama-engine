<?php

namespace Sendama\Engine\Animation\Interfaces;

use Sendama\Engine\Animation\Enumerations\WrapMode;
use Sendama\Engine\Core\Sprite as Frame;

interface AnimationClipInterface
{
  /**
   * Returns the name of the animation clip.
   *
   * @return string The name of the animation clip.
   */
  public function getName(): string;

  /**
   * Returns the frame rate of the animation clip.
   *
   * @return float The frame rate of the animation clip.
   */
  public function getFrameRate(): float;

  /**
   * Returns the wrap mode of the animation clip.
   *
   * @return WrapMode The wrap mode of the animation clip.
   */
  public function getWrapMode(): WrapMode;

  /**
   * Returns whether the animation clip is empty.
   *
   * @return bool True if the animation clip is empty, false otherwise.
   */
  public function isEmpty(): bool;

  /**
   * Returns the length of the animation clip in seconds.
   *
   * @return float The length of the animation clip in seconds.
   */
  public function getLength(): float;

  /**
   * Returns the number of frames in the animation clip.
   *
   * @return int The number of frames in the animation clip.
   */
  public function getTotalFrames(): int;

  /**
   * Adds a frame to the animation clip.
   *
   * @param Frame $frame The frame to add.
   */
  public function addFrame(Frame $frame): void;

  /**
   * Sets the frame at the specified index.
   *
   * @param int $index The index of the frame.
   * @param Frame $frame The frame to set.
   */
  public function setFrame(int $index, Frame $frame): void;

  /**
   * Removes the frame at the specified index.
   *
   * @param int $index The index of the frame.
   */
  public function removeFrame(int $index): void;

  /**
   * Returns the frame at the specified index.
   *
   * @param int $index The index of the frame.
   * @return Frame|null The frame at the specified index.
   */
  public function getFrame(int $index): ?Frame;
}