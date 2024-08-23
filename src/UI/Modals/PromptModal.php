<?php

namespace Sendama\Engine\UI\Modals;

use Sendama\Engine\UI\Modals\Modal;

/**
 * The PromptModal class represents a modal that displays a prompt message.
 *
 * @package Sendama\Engine\UI\Modals
 */
class PromptModal extends Modal
{
  /**
   * Constructs a new PromptModal instance.
   *
   * @param string $message The message to display.
   * @param string $title The title of the modal.
   * @param string $default The default value of the prompt.
   * @param int $width The width of the modal.
   */
  public function __construct(string $message, string $title, string $default ='', int $width = DEFAULT_DIALOG_WIDTH)
  {
    parent::__construct(message: $message, title: $title, width: $width);
    $this->value = $default;
  }

  /**
   * @inheritDoc
   */
  protected function submit(): void
  {
    $this->hide();
  }
}