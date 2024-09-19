<?php

namespace Sendama\Engine\UI\Modals;

use Sendama\Engine\UI\Modals\Modal;

class ConfirmModal extends Modal
{
  /**
   * Constructs a new ConfirmModal instance.
   *
   * @param string $message The message to display.
   * @param string $title The title of the modal.
   * @param int $width The width of the modal.
   * @param string $confirmButton The confirm button text.
   * @param string $cancelButton The cancel button text.
   */
  public function __construct(
    string $message,
    string $title,
    int $width = DEFAULT_DIALOG_WIDTH,
    string $confirmButton = 'OK',
    string $cancelButton = 'Cancel'
  )
  {
    parent::__construct(message: $message, title: $title, width: $width, buttons: [$confirmButton, $cancelButton]);
  }

  /**
   * @inheritDoc
   */
  protected function submit(): void
  {
    parent::submit();
    $this->value = $this->getActiveIndex() === 0;
  }
}