<?php

namespace Sendama\Engine\Util\Config;

use Sendama\Engine\Exceptions\NotFoundException;
use Sendama\Engine\Exceptions\SendamaException;
use Sendama\Engine\Util\Path;

/**
 * Class AppConfig. Represents the application configuration.
 *
 * @package Sendama\Engine\Util\Config
 */
class AppConfig extends AbstractConfig
{
  /**
   * @inheritDoc
   * @throws SendamaException
   */
  protected function load(): array
  {
    $content = file_get_contents($this->filename);

    if (false === $content) {
      throw new SendamaException("Could not read file: $this->filename");
    }

    $config = json_decode($content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new SendamaException('Could not decode JSON: ' . json_last_error_msg());
    }

    return $config;
  }

  /**
   * @inheritDoc
   * @throws NotFoundException
   */
  protected function getFilename(): string
  {
    $filename = Path::join(Path::getCurrentWorkingDirectory(), 'sendama.json');

    if (!file_exists($filename)) {
      throw new NotFoundException($filename);
    }

    return $filename;
  }
}