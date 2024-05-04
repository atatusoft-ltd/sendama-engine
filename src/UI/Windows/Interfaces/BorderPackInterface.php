<?php

namespace Sendama\Engine\UI\Windows\Interfaces;

/**
 * Interface BorderPackInterface. Represents a border pack.
 *
 * @package Sendama\Engine\UI\Windows\Interfaces
 */
interface BorderPackInterface
{
  /**
   * Returns the top left corner.
   *
   * @return string The top left corner.
   */
  public function getTopLeftCorner(): string;

  /**
   * Returns the top right corner.
   *
   * @return string The top right corner.
   */
  public function getTopRightCorner(): string;

  /**
   * Returns the bottom left corner.
   *
   * @return string The bottom left corner.
   */
  public function getBottomLeftCorner(): string;

  /**
   * Returns the bottom right corner.
   *
   * @return string The bottom right corner.
   */
  public function getBottomRightCorner(): string;

  /**
   * Returns the horizontal border.
   *
   * @return string The horizontal border.
   */
  public function getHorizontalBorder(): string;

  /**
   * Returns the vertical border.
   *
   * @return string The vertical border.
   */
  public function getVerticalBorder(): string;

  /**
   * Returns the top horizontal connector.
   *
   * @return string The top horizontal connector.
   */
  public function getTopHorizontalConnector(): string;

  /**
   * Returns the bottom horizontal connector.
   *
   * @return string The bottom horizontal connector.
   */
  public function getBottomHorizontalConnector(): string;

  /**
   * Returns the left vertical connector.
   *
   * @return string The left vertical connector.
   */
  public function getLeftVerticalConnector(): string;

  /**
   * Returns the right vertical connector.
   *
   * @return string The right vertical connector.
   */
  public function getRightVerticalConnector(): string;

  /**
   * Returns the center connector.
   *
   * @return string The center connector.
   */
  public function getCenterConnector(): string;
}