<?php

namespace test\unit\service;

use Faker\Factory;
use com\linways\core\dto\HelloWorld;
use test\unit\HelloWorldAPITestCase;
use com\linways\core\constant\StatusConstants;
use com\linways\core\service\HelloWorldService;
use com\linways\core\request\SearchHelloWorldRequest;
use com\linways\core\constant\HelloWorldTypeConstants;

class HelloWorldServiceTest extends HelloWorldAPITestCase
{
    protected function setUp()
    {
        parent::setUp();
        
    }
    Generating code coverage report in HTML format ... done
    vivekkp@vivekkp-HP-Laptop-15-da0xxx:/var/www/html/linways/training-api$ ./vendor/bin/phpunit test/unit/service/HelloWorldServiceTest.php 
    bootstrap/     composer.json  db/            .gitignore     phinx.yml      public/        sr
    Generating code coverage report in HTML format ... done
    vivekkp@vivekkp-HP-Laptop-15-da0xxx:/var/www/html/linways/training-api$ ./vendor/bin/phpunit test/unit/service/HelloWorldServiceTest.php 
    bootstrap/     composer.json  db/            .gitignore     phinx.yml      public/        sr

    protected function tearDown()
    {
    }

    public function testSaveHelloWorld()
    {
    }
}