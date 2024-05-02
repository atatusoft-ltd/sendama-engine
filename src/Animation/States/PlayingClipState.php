<?php

namespace Sendama\Engine\Animation\States;

use Sendama\Engine\Animation\States\AnimationControllerState;

class PlayingClipState extends AnimationControllerState
{
  /**
   * @inheritDoc
   */
  public function playClip(): void
  {
    // TODO: Implement playClip() method.
  }

  /**
   * @inheritDoc
   */
  public function pauseClip(): void
  {
    $this->context->setState($this->context->pausedState);
    // TODO: Implement pauseClip() method.
  }

  /**
   * @inheritDoc
   */
  public function resumeClip(): void
  {
    $this->context->setState($this->context->playingState);

    // TODO: Implement resumeClip() method.
  }

  /**
   * @inheritDoc
   */
  public function stopClip(): void
  {
    $this->context->setState($this->context->stoppedState);
    $this->context->stopClip();
  }
}