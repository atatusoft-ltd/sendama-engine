<?php

namespace Sendama\Examples\Blasters\Scripts\Player;

use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Debug\Debug;

class WeaponManager extends Behaviour
{
  public function fire(): void
  {
    Debug::log('Ama faring mah lazar!');
  }
}