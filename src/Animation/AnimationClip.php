<?php

namespace Sendama\Engine\Animation;

use Sendama\Engine\Animation\Enumerations\WrapMode;
use Sendama\Engine\Animation\Interfaces\AnimationClipInterface;
use Sendama\Engine\Core\Sprite as Frame;

/**
 * Class AnimationClip
 *
 * Represents an animation clip.
 */
class AnimationClip implements AnimationClipInterface
{
  /**
   * AnimationClip constructor.
   *
   * @param string $name The name of the animation clip.
   * @param float $frameRate The frame rate of the animation clip.
   * @param WrapMode $wrapMode The wrap mode of the animation clip.
   * @param Frame[] $frames The frames of the animation clip.
   */
  public function __construct(
    protected string $name,
    protected float $frameRate = 1.0,
    protected WrapMode $wrapMode = WrapMode::ONCE,
    protected array $frames = []
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @inheritDoc
   */
  public function getFrameRate(): float
  {
    return $this->frameRate;
  }

  /**
   * @inheritDoc
   */
  public function getWrapMode(): WrapMode
  {
    return $this->wrapMode;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool
  {
    return empty($this->frames);
  }

  /**
   * @inheritDoc
   */
  public function getLength(): float
  {
    return count($this->frames) / $this->frameRate;
  }

  /**
   * @inheritDoc
   */
  public function getTotalFrames(): int
  {
    return count($this->frames);
  }

  /**
   * @inheritDoc
   */
  public function addFrame(Frame $frame): void
  {
    $this->frames[] = $frame;
  }

  /**
   * @inheritDoc
   */
  public function setFrame(int $index, Frame $frame): void
  {
    $this->frames[$index] = $frame;
  }

  /**
   * @inheritDoc
   */
  public function removeFrame(int $index): void
  {
    unset($this->frames[$index]);
  }

  /**
   * @inheritDoc
   */
  public function getFrame(int $index): ?Frame
  {
    return $this->frames[$index] ?? null;
  }
}