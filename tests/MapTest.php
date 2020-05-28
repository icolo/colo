<?php
require_once 'vendor/autoload.php';
require_once __DIR__.'/../colo/autoload.php';
require_once __DIR__.'/classes/Hello.php';

class MapTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \colo\Engine
     */
    private $app;

    function setUp() {
        $this->app = new \colo\Engine();
    }

    // Map a closure
    function testClosureMapping(){
        $this->app->map('map1', function(){
            return 'hello';
        });

        $result = $this->app->map1();

        $this->assertEquals('hello', $result);
    }

    // Map a function
    function testFunctionMapping(){
        $this->app->map('map2', function(){
            return 'hello';
        });

        $result = $this->app->map2();

        $this->assertEquals('hello', $result);
    }

    // Map a class method
    function testClassMethodMapping(){
        $h = new Hello();

        $this->app->map('map3', array($h, 'sayHi'));

        $result = $this->app->map3();

        $this->assertEquals('hello', $result);
    }

    // Map a static class method
    function testStaticClassMethodMapping(){
        $this->app->map('map4', array('Hello', 'sayBye'));

        $result = $this->app->map4();

        $this->assertEquals('goodbye', $result);
    }

    // Unmapped method
    function testUnmapped() {
        $this->setExpectedException('Exception', 'doesNotExist must be a mapped method.');

        $this->app->doesNotExist();
    }
}
