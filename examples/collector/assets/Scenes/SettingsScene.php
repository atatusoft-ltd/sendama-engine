<?php

namespace Sendama\Examples\Collector\Scenes;

use Sendama\Engine\Core\Behaviours\SimpleBackListener;
use Sendama\Engine\Core\Behaviours\SimpleQuitListener;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Scenes\AbstractScene;

class SettingsScene extends AbstractScene
{
  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $levelManager = new GameObject('Level Manager');
    $levelManager->addComponent(SimpleQuitListener::class);
    $levelManager->addComponent(SimpleBackListener::class);

    $this->add($levelManager);
  }
}