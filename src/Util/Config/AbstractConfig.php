<?php

namespace Sendama\Engine\Util\Config;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Exceptions\SendamaException;
use Sendama\Engine\Util\Interfaces\ConfigInterface;

/**
 * The abstract configuration class.
 *
 * @package Sendama\Engine\Util\Config
 */
abstract class AbstractConfig implements ConfigInterface
{
  /**
   * The configuration array.
   *
   * @var array
   */
  protected array $config = [];
  protected string $filename;

  /**
   * AbstractConfig constructor.
   *
   * @param array $options The options to use.
   */
  public function __construct(protected array $options = [])
  {
    $this->config = $this->load();
    $this->filename = $this->getFilename();
  }

  /**
   * @inheritDoc
   */
  public function get(string $path, mixed $default = null): mixed
  {
    $config = $this->config;
    $keys = explode('.', $path);

    foreach ($keys as $path) {
      if (isset($config[$path])) {
        $config = $config[$path];
      } else {
        return $default;
      }
    }

    return $config;
  }

  /**
   * @inheritDoc
   */
  public function set(string $path, mixed $value): void
  {
    $config = &$this->config;
    $keys = explode('.', $path);

    foreach ($keys as $path) {
      if (!isset($config[$path])) {
        $config[$path] = [];
      }

      $config = &$config[$path];
    }

    $config = $value;
  }

  /**
   * @inheritDoc
   */
  public function has(string $path): bool
  {
    $config = $this->config;
    $keys = explode('.', $path);

    foreach ($keys as $path) {
      if (isset($config[$path])) {
        $config = $config[$path];
      } else {
        return false;
      }
    }

    return true;
  }


  /**
   * @inheritDoc
   * @throws SendamaException
   */
  public function persist(): void
  {
    $content = json_encode($this->config, JSON_PRETTY_PRINT);

    if (false === $content) {
      throw new SendamaException("Could not encode JSON: " . json_last_error_msg());
    }

    $bytes = file_put_contents($this->filename, $content);

    if (false === $bytes) {
      throw new SendamaException("Could not write to file: $this->filename");
    }

    if ($bytes !== strlen($content)) {
      throw new SendamaException("Could not write all bytes to file: $this->filename");
    }

    $basename = basename($this->filename);
    $humanReadableBytes = number_format($bytes);

    Debug::info("Update $basename ($humanReadableBytes)");
  }

  /**
   * Loads the configuration.
   *
   * @return array The configuration array.
   */
  protected abstract function load(): array;

  /**
   * Returns the filename of the configuration.
   *
   * @return string The filename of the configuration.
   */
  protected abstract function getFilename(): string;
}