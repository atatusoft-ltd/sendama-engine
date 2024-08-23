<?php

namespace Sendama\Engine\UI\Modals\Enumerations;

/**
 * Class ModalEventType. Represents the type of modal event.
 */
enum ModalEventType
{
  case SHOW;
  case HIDE;
  case UPDATE;
  case RENDER;
  case ACTION;
  case OPEN;
  case CLOSE;
  case CONFIRM;
  case CANCEL;
}
