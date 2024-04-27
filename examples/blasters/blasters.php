#!/usr/bin/env php
<?php

require_once '../../vendor/autoload.php';

use Sendama\Engine\Game;

function bootstrap(): void
{
  $game = new Game("Blasters");

  $game
    ->loadSettings()
    ->run();
}

bootstrap();