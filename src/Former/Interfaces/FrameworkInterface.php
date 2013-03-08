<?php
namespace Former\Interfaces;

use Former\Form\Actions;
use Former\Form\Group;
use Former\Traits\Field;
use HtmlObject\Element;
use Illuminate\Container\Container;

/**
 * Mandatory methods on all frameworks
 */
interface FrameworkInterface
{
  public function __construct(Container $app);

  // Filter arrays
  public function filterButtonClasses($classes);
  public function filterFieldClasses($classes);
  public function filterState($state);

  // Add classes to attributes
  public function getFieldClasses(Field $field, $classes);
  public function getGroupClasses();
  public function getLabelClasses();
  public function getFormClasses($type);
  public function getUneditableClasses();
  public function getActionClasses();

  // Render blocks
  public function createLabelOf(Field $field, Element $label);
  public function createHelp($text, $attributes);
  public function createIcon($icon, $attributes);
  public function createDisabledField(Field $field);

  // Wrap blocks (hooks)
  public function wrapField($field);
}
