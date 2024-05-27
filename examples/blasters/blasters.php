#!/usr/bin/env php
<?php

require_once '../../vendor/autoload.php';

use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Engine\Game;
use Sendama\Engine\UI\Menus\MenuItems\MenuItem;
use Sendama\Examples\Blasters\Scenes\HighScoresScene;
use Sendama\Examples\Blasters\Scenes\Level01;
use Sendama\Examples\Blasters\Scenes\SettingsScene;

function bootstrap(): void
{
  $gameName = 'Blasters';
  $screenWidth = 140;
  $screenHeight = 30;

  $game = new Game($gameName, $screenWidth, $screenHeight);

  $titleScene = new TitleScene($gameName);
  $titleScene
    ->setTitleFont('graffiti')
    ->addMenuItems(
      new MenuItem('High Scores', 'A list of high scores.', 'H', fn() => loadScene('High Scores')),
      new MenuItem('Settings', 'Manage game settings.', '⚙️', fn() => loadScene('Settings')),
    );

  $game->addScenes(
    $titleScene,
    new Level01('Level01'),
    new SettingsScene('Settings'),
    new HighScoresScene('High Scores')
  );

  $game
    ->loadSettings()
    ->run();
}

bootstrap();