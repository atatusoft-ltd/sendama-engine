<?php

namespace Sendama\Examples\Blasters\Scripts;

use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;
use Sendama\Examples\Blasters\Scripts\Player\WeaponManager;

class PlayerController extends Behaviour
{
  #[SerializeField]
  private ?WeaponManager $weaponManager;

  public function onStart(): void
  {
    Debug::info("PlayerController started");
    $this->weaponManager = $this->getComponent(WeaponManager::class);

    if (!$this->weaponManager)
    {
      Debug::error("WeaponManager not found");
    }
  }

  public function onUpdate(): void
  {
    if (Input::isAnyKeyPressed([KeyCode::SPACE, KeyCode::ENTER]))
    {
      $this->fire();
    }
  }

  private function fire(): void
  {
    $this->weaponManager?->fire();
  }
}