<?php

namespace Sendama\Engine\IO;

use ReflectionAttribute;
use ReflectionObject;
use ReflectionProperty;
use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\Core\Interfaces\ComponentInterface;
use Sendama\Engine\Core\Interfaces\SingletonInterface;

class GameSerializer implements SingletonInterface
{
  public const string UNGROUPED_HEADER = '__ungrouped';

  protected static ?GameSerializer $instance;

  private function __construct()
  {
    // This is a singleton class.
  }

  /**
   * @inheritDoc
   */
  public static function getInstance(): SingletonInterface
  {
    if (!self::$instance)
    {
      self::$instance = new GameSerializer();
    }

    return self::$instance;
  }

  /**
   * Get the serializable fields of a component.
   *
   * @param ComponentInterface $component The component.
   * @return ReflectionProperty[] The serializable fields of the component.
   */
  public function getComponentSerializableFields(ComponentInterface $component): array
  {
    $header = self::UNGROUPED_HEADER;
    $fields = [
      $header => []
    ];

    $properties = (new ReflectionObject($component))->getProperties();

    foreach($properties as $prop)
    {
      $isSerializableField = false;

      if ($attributes = $prop->getAttributes())
      {
        $header = ($attributes[0]->newInstance())->text;
        $isSerializableField = $this->isSerializableField($attributes);
      }

      if ($prop->isPublic() || $isSerializableField)
      {
        $fields[$header][] = $prop;
      }
    }
    return $fields;
  }

  /**
   * Check if a field is serializable.
   *
   * @param array<ReflectionAttribute> $fieldAttributes The field attributes.
   * @return bool Whether the field is serializable or not.
   */
  private function isSerializableField(array $fieldAttributes): bool
  {
    foreach ($fieldAttributes as $attribute)
    {
      if ($attribute instanceof ReflectionAttribute)
      {
        $instance = $attribute->newInstance();

        if ($instance instanceof SerializeField)
        {
          return true;
        }
      }
    }

    return false;
  }
}