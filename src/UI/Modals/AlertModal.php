<?php

namespace Sendama\Engine\UI\Modals;

/**
 * The AlertModal class represents a modal that displays an alert message.
 *
 * @package Sendama\Engine\UI\Modals
 */
class AlertModal extends Modal
{
  /**
   * Constructs a new AlertModal instance.
   *
   * @param string $message The message to display.
   * @param string $title The title of the modal.
   * @param int $width The width of the modal.
   */
  public function __construct(
    string $message,
    string $title,
    int $width = DEFAULT_DIALOG_WIDTH,
  )
  {
    parent::__construct(message: $message, title: $title, width: $width);
  }
}