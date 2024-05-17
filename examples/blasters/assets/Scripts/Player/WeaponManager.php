<?php

namespace Sendama\Examples\Collector\Scripts\Player;

use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Debug\Debug;

class WeaponManager extends Behaviour
{
  public function fire(): void
  {
    Debug::log('Ama faring mah lazar!');
  }
}