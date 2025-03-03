<?php

namespace Sendama\Engine\IO\Storage;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\IO\Storage\Interfaces\StorageInterface;
use Sendama\Engine\Util\Path;

/**
 * Represents a file storage.
 *
 * @package Sendama\Engine\IO\Storage
 */
class FileStorage implements StorageInterface
{
  /**
   * @var FileStorage|null $instance
   */
  protected static ?FileStorage $instance = null;

  /**
   * @var array<string, mixed> $data
   */
  protected array $data = [];

  /**
   * @var string $path
   */
  protected string $path = '';

  /**
   * FileStorage constructor.
   */
  private function __construct()
  {
    // This is a singleton.
  }

  /**
   * @inheritDoc
   */
  public static function getInstance(): self
  {
    if (!self::$instance) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * @inheritDoc
   */
  public function load(string $path): void
  {
    $this->path = $path;

    if (!file_exists($this->getSaveFilename())) {
      $this->createSaveFile();
    }
  }

  /**
   * Returns the absolute path to the storage.
   *
   * @return string The absolute path to the storage.
   */
  private function getSaveFilename(): string
  {
    return Path::join(Path::getWorkingDirectoryAssetsPath(), $this->path . '.sedata');
  }

  /**
   * Creates the save file.
   */
  private function createSaveFile(): void
  {
    if (!touch($this->getSaveFilename())) {
      Debug::error("Failed to create the save file {$this->getSaveFilename()}.");
    } else {
      Debug::info("Created the save file $this->path.");
    }
  }

  /**
   * @inheritDoc
   */
  public function save(): void
  {
    $data = json_encode($this->data);
    $bytes = file_put_contents($this->getSaveFilename(), $data);

    if ($bytes === false) {
      Debug::error("Failed to save the data to the storage.");
    } else {
      Debug::info("Saved the data to the storage. ($bytes) bytes");
    }
  }

  /**
   * @inheritDoc
   */
  public function get(string $key): mixed
  {
    if (!isset($this->data[$key])) {
      Debug::warn("The key '$key' does not exist in the storage.");
      return null;
    }

    return $this->data[$key];
  }

  /**
   * @inheritDoc
   */
  public function set(string $key, mixed $data): void
  {
    $this->data[$key] = $data;
  }

  /**
   * @inheritDoc
   */
  public function delete(string $path): void
  {
    if (!unlink($this->getSaveFilename())) {
      Debug::error("Failed to delete the save file {$this->getSaveFilename()}.");
    } else {
      Debug::info("Deleted the save file $this->path.");
    }
  }
}