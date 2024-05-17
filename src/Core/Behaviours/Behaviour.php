<?php

namespace Sendama\Engine\Core\Behaviours;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Rendering\Renderer;

/**
 * Behaviour class. This class is the base class for all behaviours in the engine.
 */
abstract class Behaviour extends Component
{
  public final function __construct(GameObject $gameObject)
  {
    parent::__construct($gameObject);
  }
}