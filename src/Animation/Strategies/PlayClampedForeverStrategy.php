<?php

namespace Sendama\Engine\Animation\Strategies;

use Sendama\Engine\Animation\Strategies\PlayStrategy;
use Sendama\Engine\Exceptions\NotImplementedException;

/**
 * Class PlayClampedForeverStrategy
 * @package Sendama\Engine\Animation\Strategies
 */
class PlayClampedForeverStrategy extends PlayStrategy
{

  /**
   * @inheritDoc
   */
  public function playClip(): void
  {
    // TODO: Implement playClip() method.
    throw new NotImplementedException(__METHOD__);
  }
}