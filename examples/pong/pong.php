<?php

use Sendama\Engine\Game;

function boostrap(): void
{
  $gameName = 'Pong'; // This will be overwritten by the .env file
  $game = new Game($gameName);
  $game->loadSettings();
}

bootstrap();