#!/usr/bin/env php
<?php

require_once '../../vendor/autoload.php';

use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Engine\Game;
use Sendama\Examples\Blasters\Scenes\HighScoresScene;
use Sendama\Examples\Blasters\Scenes\Level01;
use Sendama\Examples\Blasters\Scenes\SettingsScene;

function bootstrap(): void
{
  $gameName = 'Blasters';
  $screenWidth = 80;
  $screenHeight = 30;

  $game = new Game($gameName, $screenWidth, $screenHeight);

  $game->addScenes(
    new TitleScene($gameName),
    new Level01('Level01'),
    new SettingsScene('Settings'),
    new HighScoresScene('High Scores')
  );

  $game
    ->loadSettings()
    ->run();
}

bootstrap();