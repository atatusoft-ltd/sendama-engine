<?php

namespace Sendama\Examples\Collector\Scripts\Game\Events;

use Sendama\Engine\Events\GameplayEvent;

readonly class ScoreUpdateEvent extends GameplayEvent
{
  public function __construct(public int $score)
  {
    parent::__construct();
  }
}