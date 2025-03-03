<?php

namespace Sendama\Engine\Util\Config;

use Sendama\Engine\Exceptions\NotFoundException;
use Sendama\Engine\Exceptions\SendamaException;
use Sendama\Engine\Util\Path;

/**
 * Class InputConfig. Represents the input configuration.
 *
 * @package Sendama\Engine\Util\Config
 */
class InputConfig extends AbstractConfig
{
  /**
   * @inheritDoc
   * @throws SendamaException
   */
  protected function load(): array
  {
    $content = require($this->filename);

    if (false === $content) {
      throw new SendamaException("Could not read file: $this->filename");
    }

    return $content;
  }

  /**
   * @inheritDoc
   * @throws NotFoundException
   */
  protected function getFilename(): string
  {
    $filename = Path::join(Path::getCurrentWorkingDirectory(), 'config/input.php');

    if (!file_exists($filename)) {
      throw new NotFoundException($filename);
    }

    return $filename;
  }
}