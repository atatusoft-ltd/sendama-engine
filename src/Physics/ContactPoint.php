<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Vector2;

/**
 * Represents a contact point between two colliders.
 */
readonly class ContactPoint
{
  /**
   * ContactPoint constructor.
   *
   * @param Vector2 $point The point of contact.
   * @param Collider $thisCollider The collider of the game object that this contact point belongs to.
   * @param Collider $otherCollider The collider of the other game object that this contact point belongs to.
   */
  public function __construct(
    protected Vector2 $point,
    protected Collider $thisCollider,
    protected Collider $otherCollider,
  )
  {
  }

  /**
   * Get the point of contact.
   *
   * @return Vector2 The point of contact.
   */
  public function getPoint(): Vector2
  {
    return $this->point;
  }

  /**
   * Get the collider of the game object that this contact point belongs to.
   *
   * @return Collider The collider of the game object that this contact point belongs to.
   */
  public function getThisCollider(): Collider
  {
    return $this->thisCollider;
  }

  /**
   * Get the collider of the other game object that this contact point belongs to.
   *
   * @return Collider The collider of the other game object that this contact point belongs to.
   */
  public function getOtherCollider(): Collider
  {
    return $this->otherCollider;
  }

  /**
   * Get the normal of the contact point.
   *
   * @return Vector2 The normal of the contact point.
   */
  public function getNormal(): Vector2
  {
    $otherPosition = $this->otherCollider->getTransform()->getPosition();
    $thisPosition = $this->thisCollider->getTransform()->getPosition();

    return Vector2::difference($otherPosition, $thisPosition)->getNormalized();
  }

  /**
   * Get the separation of the contact point.
   *
   * @return float The separation of the contact point.
   */
  public function getSeparation(): float
  {
    return Vector2::distance(
      $this->thisCollider->getTransform()->getPosition(),
      $this->otherCollider->getTransform()->getPosition()
    );
  }
}