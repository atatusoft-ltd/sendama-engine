<?php

namespace Sendama\Engine\Animation\States;

use Sendama\Engine\Animation\AnimationController;
use Sendama\Engine\Animation\Interfaces\AnimationControllerStateInterface;

abstract class AnimationControllerState implements AnimationControllerStateInterface
{
  /**
   * AnimationControllerState constructor. This is the constructor of the state.
   *
   * @param AnimationController $context The context of the state.
   */
  public final function __construct(protected AnimationController $context)
  {
  }
}