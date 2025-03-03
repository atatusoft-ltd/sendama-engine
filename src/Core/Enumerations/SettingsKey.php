<?php

namespace Sendama\Engine\Core\Enumerations;

/**
 * Class SettingsKey. Represents the settings keys.
 *
 * @package Sendama\Engine\Core\Enumerations
 */
enum SettingsKey: string
{
  case DEBUG = 'debug';
  case DEBUG_INFO = 'debug_info';
  case LOG_LEVEL = 'log_level';
  case LOG_DIR = 'log_dir';
  case GAME_NAME = 'game_name';
  case SCREEN_WIDTH = 'screen_width';
  case SCREEN_HEIGHT = 'screen_height';
  case SCREEN_TITLE = 'screen_title';
  case FPS = 'fps';
  case ASSETS_DIR = 'assets_path';
  case INITIAL_SCENE = 'initial_scene';
  case SPLASH_TEXTURE = 'splash_texture';
  case SPLASH_DURATION = 'splash_screen_duration';
  case BUTTONS = 'buttons';
  case PAUSE_KEY = 'pause_key';
  case BORDER_PACK = 'border_pack';
}
