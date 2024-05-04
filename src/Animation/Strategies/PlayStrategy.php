<?php

namespace Sendama\Engine\Animation\Strategies;

use Sendama\Engine\Animation\AnimationController;

/**
 * Class PlayStrategy. This is the strategy class for playing the clip in the animation controller.
 *
 * @package Sendama\Engine\Animation\Strategies
 */
abstract class PlayStrategy
{
  /**
   * PlayStrategy constructor.
   * @param AnimationController $context
   */
  public function __construct(protected AnimationController $context)
  {
  }

  /**
   * Play the clip
   */
  public abstract function playClip(): void;
}