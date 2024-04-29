#!/usr/bin/env php
<?php

require_once '../../vendor/autoload.php';

use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Engine\Game;

function bootstrap(): void
{
  $game = new Game("Blasters");

  $game->addScenes(new TitleScene());

  $game
    ->loadSettings()
    ->run();
}

bootstrap();