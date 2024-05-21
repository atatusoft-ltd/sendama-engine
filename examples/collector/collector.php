<?php

use Amasiye\Figlet\FontName;
use Sendama\Engine\Game;
use Sendama\Engine\Core\Scenes\TitleScene;
use Sendama\Examples\Collector\Scenes\Level01;
use Sendama\Examples\Collector\Scenes\Level02;

require '../../vendor/autoload.php';

function bootstrap(): void
{
  $gameName = 'The Collector'; // This will be overwritten by the .env file
  $game = new Game($gameName);

  $titleScene = new TitleScene('Title Screen');
  $titleScene->setTitle($gameName);
  $titleScene->setTitleFont(FontName::BASIC);

  $game->addScenes(
    $titleScene,
    new Level01('Level01'),
    new Level02('Level02'),
  );

  $game
    ->loadSettings()
    ->run();
}

bootstrap();