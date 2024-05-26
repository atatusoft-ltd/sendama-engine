<?php

namespace Sendama\Examples\Collector\Scripts\Enumerations;

/**
 * This is a simple enumeration of names for game objects.
 *
 * @package Sendama\Examples\Collector\Scripts\Enumerations
 */
enum Name: string
{
  case PLAYER = 'Player';
  case LEVEL_MANAGER = 'Level Manager';
  case APPLE = 'Apple';
}
