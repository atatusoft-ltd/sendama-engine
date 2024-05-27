<?php

namespace Sendama\Engine\UI\Menus;

use Assegai\Collections\ItemList;
use Closure;
use Sendama\Engine\Core\Interfaces\ExecutionContextInterface;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Scenes\SceneManager;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Enumerations\Color;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;
use Sendama\Engine\UI\Interfaces\UIElementInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuGraphNodeInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuInterface;
use Sendama\Engine\UI\Menus\Interfaces\MenuItemInterface;
use Sendama\Engine\UI\UIElement;
use Sendama\Engine\UI\Windows\Window;

/**
 * Class Menu. Represents a menu.
 *
 * @package Sendama\Engine\UI\Menus
 */
class Menu implements MenuInterface
{
  /**
   * @var bool $activated
   */
  protected bool $activated = true;
  /**
   * @var MenuItemInterface|null $activeItem
   */
  protected ?MenuItemInterface $activeItem = null;
  /**
   * @var ItemList<ObserverInterface> $observers
   */
  protected ItemList $observers;
  /**
   * @var MenuGraphNodeInterface|null $topSibling
   */
  protected ?MenuGraphNodeInterface $topSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $rightSibling
   */
  protected ?MenuGraphNodeInterface $rightSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $bottomSibling
   */
  protected ?MenuGraphNodeInterface $bottomSibling = null;
  /**
   * @var MenuGraphNodeInterface|null $leftSibling
   */
  protected ?MenuGraphNodeInterface $leftSibling = null;
  /**
   * @var Window $window
   */
  protected Window $window;
  /**
   * @var bool $enabled
   */
  protected bool $enabled = true;
  /**
   * @var bool $rememberCursorPosition
   */
  protected bool $rememberCursorPosition = false;
  /**
   * @var int $savedCursorPosition
   */
  protected int $savedCursorPosition = 0;

  /**
   * Menu constructor.
   *
   * @param string $title The title of the menu.
   * @param string $description The description of the menu.
   * @param Rect $dimensions The dimensions of the menu.
   * @param ItemList $items The items of the menu.
   * @param string $cursor The cursor of the menu.
   * @param Color $activeColor The active color of the menu.
   * @param array<KeyCode>|null $cancelKey The cancel key.
   * @param Closure|null $onCancel The on cancel callback.
   * @param bool $canNavigate Whether the menu can navigate or not.
   */
  public function __construct(
    protected string   $title,
    protected string   $description = '',
    protected Rect     $dimensions = new Rect(
      new Vector2(0, 0),
      new Vector2(DEFAULT_MENU_WIDTH, DEFAULT_MENU_HEIGHT)
    ),
    protected ItemList $items = new ItemList(MenuItemInterface::class),
    protected string   $cursor = '>',
    protected Color    $activeColor = Color::BLUE,
    protected ?array   $cancelKey = null,
    protected ?Closure $onCancel = null,
    protected bool     $canNavigate = true,
  )
  {
    if (! $this->canNavigate)
    {
      $this->cursor = '';
    }

    $this->observers = new ItemList(ObserverInterface::class);
    $this->window = new Window(
      $this->title,
      $this->description,
      $this->dimensions->getPosition(),
      $this->dimensions->getWidth(),
      $this->dimensions->getHeight()
    );
  }

  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->window->render();
  }

  /**
   * @inheritDoc
   */
  public function renderAt(?int $x = null, ?int $y = null): void
  {
    $this->window->renderAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function erase(): void
  {
    $this->window->erase();
  }

  /**
   * @inheritDoc
   */
  public function eraseAt(?int $x = null, ?int $y = null): void
  {
    $this->window->eraseAt($x, $y);
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if ($this->canNavigate)
    {
      $this->handleNavigation();

      // Handle submitting the active item.
      if (Input::isKeyDown(KeyCode::ENTER))
      {
        $this->getActiveItem()?->execute($this);
      }
    }

    // Handle cancel the menu.
    if ($this->cancelKey && Input::isAnyKeyPressed($this->cancelKey))
    {
      $this->onCancel?->call($this);
    }
  }

  /**
   * @inheritDoc
   */
  public function getTitle(): string
  {
    return $this->title;
  }

  /**
   * @inheritDoc
   */
  public function setTitle(string $title): void
  {
    $this->title = $title;
  }

  /**
   * @inheritDoc
   */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @inheritDoc
   */
  public function setDescription(string $description): void
  {
    $this->description = $description;
  }

  /**
   * @inheritDoc
   */
  public function getItems(): ItemList
  {
    return $this->items;
  }

  /**
   * @inheritDoc
   */
  public function setItems(ItemList $items): void
  {
    $this->items = $items;
  }

  /**
   * @inheritDoc
   */
  public function addItem(MenuItemInterface $item): void
  {
    $this->items->add($item);
    if (!$this->getActiveItem())
    {
      $this->setActiveItem($item);
    }
    $this->updateWindowContent();
  }

  /**
   * @inheritDoc
   */
  public function removeItem(MenuItemInterface $item): void
  {
    $this->items->remove($item);
  }

  /**
   * @inheritDoc
   */
  public function removeItemByIndex(int $index): void
  {
    $this->items->removeAt($index);
  }

  /**
   * @inheritDoc
   */
  public function getItemByIndex(int $index): ?MenuItemInterface
  {
    return $this->items->toArray()[$index] ?? null;
  }

  /**
   * @inheritDoc
   */
  public function getItemByLabel(string $label): ?MenuItemInterface
  {
    return $this->items->find(fn(MenuItemInterface $item) => $item->getLabel() === $label);
  }

  /**
   * @inheritDoc
   */
  public function getActiveItem(): ?MenuItemInterface
  {
    return $this->activeItem;
  }

  /**
   * @inheritDoc
   */
  public function setActiveItem(MenuItemInterface $item): void
  {
    $this->activeItem = $item;
  }

  /**
   * @inheritDoc
   */
  public function getActiveItemIndex(): int
  {
    $index = -1;

    foreach ($this->items as $i => $item)
    {
      if ($item === $this->activeItem)
      {
        $index = $i;
        break;
      }
    }

    return $index;
  }

  /**
   * @inheritDoc
   */
  public function setActiveItemByIndex(int $index): void
  {
    $this->activeItem = $this->getItemByIndex($index);
  }

  /**
   * @inheritDoc
   */
  public function setActiveItemByLabel(string $label): void
  {
    if ($item = $this->getItemByLabel($label))
    {
      $this->activeItem = $item;
    }
  }

  /**
   * @inheritDoc
   */
  public function addObservers(ObserverInterface|StaticObserverInterface|string ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->add($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(ObserverInterface|StaticObserverInterface|string|null ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->remove($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer)
    {
      if ($observer instanceof StaticObserverInterface)
      {
        $observer::onNotify($this, $event);
        continue;
      }

      $observer->onNotify($event);
    }
  }

  /**
   * @inheritDoc
   */
  public function onFocus(EventInterface $event): void
  {
    $this->resume();
  }

  /**
   * @inheritDoc
   */
  public function onBlur(EventInterface $event): void
  {
    $this->suspend();
  }

  /**
   * @inheritDoc
   */
  public function getTop(): ?MenuGraphNodeInterface
  {
    return $this->topSibling;
  }

  /**
   * @inheritDoc
   */
  public function setTop(?MenuGraphNodeInterface $top): void
  {
    $this->topSibling = $top;
  }

  /**
   * @inheritDoc
   */
  public function getRight(): ?MenuGraphNodeInterface
  {
    return $this->rightSibling;
  }

  /**
   * @inheritDoc
   */
  public function setRight(?MenuGraphNodeInterface $right): void
  {
    $this->rightSibling = $right;
  }

  /**
   * @inheritDoc
   */
  public function getBottom(): ?MenuGraphNodeInterface
  {
    return $this->bottomSibling;
  }

  /**
   * @inheritDoc
   */
  public function setBottom(?MenuGraphNodeInterface $bottom): void
  {
    $this->bottomSibling = $bottom;
  }

  /**
   * @inheritDoc
   */
  public function getLeft(): ?MenuGraphNodeInterface
  {
    return $this->leftSibling;
  }

  /**
   * @inheritDoc
   */
  public function setLeft(?MenuGraphNodeInterface $left): void
  {
    $this->leftSibling = $left;
  }

  /**
   * @inheritDoc
   */
  public function getMenu(): ?MenuInterface
  {
    return $this;
  }

  public function setCursor(string $cursor): void
  {
    $this->cursor = $cursor;
  }

  public function setActiveColor(Color $color): void
  {
    $this->activeColor = $color;
  }

  /**
   * Updates the content of the window.
   */
  public function updateWindowContent(): void
  {
    $content = [];

    /**
     * @var int $itemIndex
     * @var MenuItemInterface $item
     */
    foreach ($this->items as $itemIndex => $item)
    {
      $output = '  ' . $item->getLabel();

      if ($itemIndex === $this->getActiveItemIndex())
      {
        $output = sprintf("%s %s", $this->cursor, $item->getLabel());
      }
      $content[] = $output;
    }

    $this->window->setContent($content);
  }

  /**
   * @inheritDoc
   */
  public function getArgs(): array
  {
    return [
      'title' => $this->title,
      'description' => $this->description,
      'dimensions' => $this->dimensions,
      'items' => $this->items,
      'cursor' => $this->cursor,
      'active_color' => $this->activeColor,
    ];
  }

  /**
   * Handles navigation.
   *
   * @void
   */
  private function handleNavigation(): void
  {
    $v = Input::getAxis(AxisName::VERTICAL);

    if ($v < 0)
    {
      // Move up.
      $this->setActiveItemByIndex(wrap($this->getActiveItemIndex() - 1, 0, $this->items->count() - 1));
    }

    if ($v > 0)
    {
      // Move down
      $this->setActiveItemByIndex(wrap($this->getActiveItemIndex() + 1, 0, $this->items->count() - 1));
    }

    // Update the window content
    $this->updateWindowContent();
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    $this->setActiveItemByIndex(0);
    $this->updateWindowContent();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->erase();
  }

  /**
   * @inheritDoc
   */
  public function start(): void
  {
    // TODO: Implement start() method.
  }

  /**
   * @inheritDoc
   */
  public function stop(): void
  {
    // TODO: Implement stop() method.
  }

  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->getTitle();
  }

  /**
   * @inheritDoc
   */
  public function setName(string $name): void
  {
    $this->setTitle($name);
  }

  /**
   * @inheritDoc
   */
  public function activate(): void
  {
    $this->activated = true;
    $this->start();
  }

  /**
   * @inheritDoc
   */
  public function deactivate(): void
  {
    $this->activated = false;
    $this->stop();
  }

  /**
   * @inheritDoc
   */
  public function isActive(): bool
  {
    return $this->activated;
  }

  /**
   * @inheritDoc
   */
  public static function find(string $uiElementName): ?self
  {
    return self::findAll($uiElementName)[0] ?? null;
  }

  /**
   * @inheritDoc
   */
  public static function findAll(string $uiElementName): array
  {
    $elements = [];

    foreach (SceneManager::getInstance()->getActiveScene()?->getUIElements() as $element)
    {
      if ($elements instanceof MenuInterface && $element->getName() === $uiElementName)
      {
        $elements[] = $element;
      }
    }

    return $elements;
  }
}