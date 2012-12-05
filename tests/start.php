<?php

// Base Test class for matchers
abstract class FormerTests extends PHPUnit_Framework_TestCase
{
  protected static $illuminate;

  protected $checkables = array(
    'Foo' => array(
      'data-foo' => 'bar',
      'value' => 'bar',
      'name' => 'foo',
    ),
    'Bar' => array(
      'data-foo' => 'bar',
      'value' => 'bar',
      'name' => 'foo',
      'id' => 'bar',
    ),
  );

  protected $testAttributes = array(
    'class'    => 'foo',
    'data-foo' => 'bar',
  );

  protected function cgr($input, $label = '<label for="foo" class="control-label">Foo</label>')
  {
    return '<div class="control-group required">'.$label.'<div class="controls">'.$input.'</div></div>';
  }

  protected function cg($input = '<input type="text" name="foo" id="foo">', $label = '<label for="foo" class="control-label">Foo</label>')
  {
    return '<div class="control-group">'.$label.'<div class="controls">'.$input.'</div></div>';
  }

  protected function cgm($input, $label = '<label class="control-label">Foo</label>')
  {
    return '<div class="control-group">'.$label.'<div class="controls">'.$input.'</div></div>';
  }

  // Setup --------------------------------------------------------- /

  public function setUp()
  {
    $this->app = static::$illuminate;

    $this->resetLabels();

    $this->app['former']->horizontal_open()->__toString();
    $this->app['former']->populate(array());
    $this->app['former']->withErrors(null);
    $this->app['former']->framework('bootstrap');
  }

  public function tearDown()
  {
    Mockery::close();
    $this->app['former']->close();
  }

  public function resetLabels()
  {
    $this->app['former.laravel.form']->labels = array();
  }

  public static function setUpBeforeClass()
  {
    $app = new Illuminate\Container;

    $app['session'] = Mockery::mock('session');
    $app['session']->shouldReceive('has')->with('errors')->andReturn(false);
    $app['session']->shouldReceive('set')->with('errors')->andReturn(false);

    $app['config'] = Mockery::mock('config');
    $app['config']->shouldReceive('get')->with('former::framework')->andReturn('bootstrap');
    $app['config']->shouldReceive('get')->with('former::fetch_errors')->andReturn(false);
    $app['config']->shouldReceive('get')->with('former::push_checkboxes')->andReturn(false);
    $app['config']->shouldReceive('get')->with('former::automatic_label')->andReturn(true);
    $app['config']->shouldReceive('get')->with('application.encoding')->andReturn('UTF-8');
    $app['config']->shouldReceive('set')->andSet('framework', 'bootstrap');

    $app['translator'] = Mockery::mock('translator');
    $app['translator']->shouldReceive('get')->with('pagination.next')->andReturn('Next &raquo;');
    $app['translator']->shouldReceive('get')->with(Mockery::any())->andReturnUsing(function($test) {
      return $test;
    });

    $app['former.laravel.form'] = $app->share(function($app) { return new Laravel\Form($app); });
    $app['former'] = $app->share(function($app) { return new Former\Former($app); });
    $app['former.helpers'] = $app->share(function($app) { return new Former\Helpers($app); });
    $app['former.framework'] = $app->share(function($app) { return new Former\Framework($app); });

    static::$illuminate = $app;
  }
}
