<?php

use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Examples\Collector\Scenes\Level01;
use Sendama\Engine\Game;

require '../../vendor/autoload.php';

function bootstrap(): void
{
  $gameName = 'The Collector'; // This will be overwritten by the .env file
  $game = new Game($gameName);

  $titleScene = new TitleScene('Title Screen');
  $titleScene->setTitle($gameName);

  $game->addScenes(
    $titleScene,
    new Level01('Level01'),
  );

  $game
    ->loadSettings()
    ->run();
}

bootstrap();