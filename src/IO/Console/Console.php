<?php

namespace Sendama\Engine\IO\Console;

use Exception;
use Sendama\Engine\Core\Grid;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\IO\Enumerations\Color;

/**
 * Console is a static class that provides console functionality.
 */
class Console
{
  /**
   * @var Grid<string> $buffer The buffer.
   */
  private static Grid $buffer;
  /**
   * @var string $previousTerminalSettings The previous terminal settings.
   */
  private static string $previousTerminalSettings = '';

  /**
   * Console constructor.
   */
  private function __construct()
  {
    // Prevent instantiation.
  }

  /**
   * Initializes the console.
   *
   * @return void
   */
  public static function init(): void
  {
    self::clear();
    Console::cursor()->disableBlinking();
  }

  /**
   * Resets the console.
   *
   * @return void
   */
  public static function reset(): void
  {
    if (false === system('reset') ) {
      echo "System reset failed";
      echo "\033c";
      self::cursor()->enableBlinking();
    }
  }

  /**
   * Enables the line wrap.
   *
   * @return void
   */
  public static function enableLineWrap(): void
  {
    echo "\033[7h";
  }

  /**
   * Disables the line wrap.
   *
   * @return void
   */
  public static function disableLineWrap(): void
  {
    echo "\033[7l";
  }

  /**
   * Returns the cursor.
   *
   * @return Cursor The cursor.
   */
  public static function cursor(): Cursor
  {
    return Cursor::getInstance();
  }

  /* Scrolling */
  /**
   * Enables scrolling.
   *
   * @param int|null $start The line to start scrolling.
   * @param int|null $end The line to end scrolling.
   * @return void
   */
  public static function enableScrolling(?int $start = null, ?int $end = null): void
  {
    if ($start !== null && $end !== null)
    {
      echo "\033[$start;{$end}r";
    }
    else if ($start !== null)
    {
      echo "\033[{$start}r";
    }
    else if ($end !== null)
    {
      echo "\033[;{$end}r";
    }
    else
    {
      echo "\033[r";
    }
  }

  /**
   * Disables scrolling.
   *
   * @return void
   */
  public static function disableScrolling(): void
  {
    echo "\033[?7l";
  }

  /**
   * Clears the console.
   *
   * @return void
   */
  public static function clear(): void
  {
    self::$buffer = self::getEmptyBuffer();
    if (PHP_OS_FAMILY === 'Windows')
    {
      system('cls');
    }
    else
    {
      system('clear');
    }
  }

  /**
   * Sets the terminal name.
   *
   * @param string $name The name of the terminal.
   * @return void
   */
  public static function setName(string $name): void
  {
    echo "\033]0;$name\007";
  }

  /**
   * Sets the terminal size.
   *
   * @param int $width The width of the terminal.
   * @param int $height The height of the terminal.
   * @return void
   */
  public static function setSize(int $width, int $height): void
  {
    echo "\033[8;$height;{$width}t";
  }

  /**
   * Returns the terminal size.
   *
   * @return Rect The terminal size.
   * @throws Exception If the terminal size cannot be retrieved.
   */
  public static function getSize(): Rect
  {
    $width = passthru("tput cols") ?: throw new Exception('Failed to get terminal width.');
    $height = passthru("tput lines") ?: throw new Exception('Failed to get terminal height.');

    return new Rect(new Vector2(1, 1), new Vector2($width, $height));
  }

  /**
   * Saves the terminal settings.
   *
   * @return void
   */
  public static function saveSettings(): void
  {
    self::$previousTerminalSettings = shell_exec('stty -g') ?? '';
  }

  /**
   * Restores the terminal settings.
   *
   * @return void
   */
  public static function restoreSettings(): void
  {
    shell_exec('stty ' . self::$previousTerminalSettings);
  }

  /**
   * Writes a single character to the console at the specified position.
   *
   * @param string $character The character to write.
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function writeChar(string $character, int $x, int $y): void
  {
    $cursor = self::cursor();

    $x = max(1, $x);
    $y = max(1, $y);

    self::$buffer->set($x, $y, substr($character, 0, 1));
    $cursor->moveTo($x, $y);
    echo self::$buffer->toArray()[$y][$x];

    $cursor->moveTo($x + 1, $y);
  }

  /**
   * Writes a message to the console at the specified position.
   *
   * @param string $message The character to write.
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function write(string $message, int $x, int $y): void
  {
    $cursor = self::cursor();
    $messageLength = strlen($message);

    $x = max(1, $x);
    $y = max(1, $y);

    for ($index = 0; $index < $messageLength; ++$index)
    {
      self::$buffer->set($x + $index, $y, $message[$index]);
      $cursor->moveTo($x + $index, $y);
      echo self::$buffer->toArray()[$y][$x + $index];
    }

    $cursor->moveTo($x + $messageLength, $y);
  }

  /**
   * Writes text to the console at the specified position.
   *
   * @param string $message The text to write.
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function writeLine(string $message, int $x, int $y): void
  {
    $cursor = self::cursor();
    $x = max(1, $x);
    $y = max(1, $y);


    $messageLength = strlen($message);
    $columnStart = $x;
    $columnEnd = $x + $messageLength;

    for ($i = $columnStart; $i < $columnEnd; $i++)
    {
      self::$buffer->set($i, $y, $message[$i - $columnStart]);
    }

    $cursor->moveTo(0, $y);
    echo implode(self::$buffer->toArray()[$y]);
    $cursor->moveTo(0, $y + 1);
  }

  /**
   * Writes text to the console at the specified position.
   *
   * @param array<string> $linesOfText The lines of text to write.
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function writeLines(array $linesOfText, int $x, int $y): void
  {
    $cursor = self::cursor();

    $x = max(1, $x);
    $y = max(1, $y);

    foreach ($linesOfText as $rowIndex => $text)
    {
      self::writeLine($text, $x, $y + $rowIndex);
    }

    $cursor->moveTo(0, $y);
  }

  /**
   * Writes text to the console at the specified position in the specified color.
   *
   * @param Color $color The color.
   * @param string $message The text to write.
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function writeInColor(Color $color, string $message, int $x, int $y): void
  {
    echo $color->value;
    self::writeLine($message, $x, $y);
    echo Color::RESET->value;
  }

  /**
   * Erases the character at the specified position.
   *
   * @param int $x The x position.
   * @param int $y The y position.
   * @return void
   */
  public static function erase(int $x, int $y): void
  {
    self::writeLine(' ', $x, $y);
  }

  /**
   * Returns the buffer.
   *
   * @return Grid The buffer.
   */
  public static function getBuffer(): Grid
  {
    return self::$buffer;
  }

  /**
   * Returns the character at the specified position.
   *
   * @param int $x The x position.
   * @param int $y The y position.
   * @return string The character at the specified position.
   */
  public static function charAt(int $x, int $y): string
  {
    if ($x < 0 || $x > DEFAULT_SCREEN_WIDTH || $y < 1 || $y > DEFAULT_SCREEN_HEIGHT)
    {
      return '';
    }

    $char = substr(self::$buffer[$y], $x, 1);
    return ord($char) === 0 ? ' ' : $char;
  }

  /**
   * Returns an empty buffer.
   *
   * @return Grid<string> The empty buffer.
   */
  private static function getEmptyBuffer(): Grid
  {
    return new Grid(DEFAULT_SCREEN_HEIGHT, DEFAULT_SCREEN_WIDTH, ' ');
  }

  /**
   * Shows a prompt dialog with the given message and title. Returns the user's input.
   *
   * @param string $message The message to show.
   * @param string $title The title of the dialog. Defaults to "Prompt".
   * @param int $width The width of the dialog. Defaults to 34.
   * @return void
   */
  public static function alert(string $message, string $title = 'Alert', int $width = DEFAULT_DIALOG_WIDTH): void
  {
    // TODO: Implement alert() method.
  }

  /**
   * Shows a confirm dialog with the given message and title. Returns true if the user confirmed, false otherwise.
   *
   * @param string $message The message to show.
   * @param string $title The title of the dialog. Defaults to "Confirm".
   * @param int $width The width of the dialog. Defaults to 34.
   * @return bool Whether the user confirmed or not.
   */
  public static function confirm(string $message, string $title = 'Confirm', int $width = DEFAULT_DIALOG_WIDTH): bool
  {
    // TODO: Implement confirm() method.
    return true;
  }

  /**
   * Shows a prompt dialog with the given message and title. Returns the user's input.
   *
   * @param string $message The message to show.
   * @param string $title The title of the dialog. Defaults to "Prompt".
   * @param string $default The default value of the input. Defaults to an empty string.
   * @param int $width The width of the dialog. Defaults to 34.
   * @return string The user's input.
   */
  public static function prompt(string $message, string $title = 'Prompt', string $default = '', int $width = DEFAULT_DIALOG_WIDTH): string
  {
    // TODO: Implement prompt() method.
    return '';
  }

  /**
   * Shows a select dialog with the given message and title. Returns the index of the selected option.
   *
   * @param string $message The message to show.
   * @param array $options The options to show.
   * @param string $title The title of the dialog. Defaults to "Select".
   * @param int $default The default option. Defaults to 0.
   * @param Vector2|null $position The position of the dialog. Defaults to null.
   * @param int $width The width of the dialog. Defaults to 34.
   * @return int The index of the selected option.
   */
  public static function select(string $message, array $options, string $title = '', int $default = 0, ?Vector2 $position = null, int $width = DEFAULT_DIALOG_WIDTH): int
  {
    // TODO: Implement select() method.
    return -1;
  }
}