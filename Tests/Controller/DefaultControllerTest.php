<?php

namespace SimpleMQ\AdminGeneratorBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	protected $atributo;
	protected static $attribute;
	protected static $attributeStatic;
    protected static $kernel;
    protected static $container;

  
	public function setUp()
	{
		$this->atributo = 'test';
		self::$attribute = 'atributo';
      	$kernel = self::getKernelClass();

        self::$kernel = new $kernel('dev', true);
        self::$kernel->boot();		
		//self::$attributeStatic = 'atributoStatic';
	}

	// public static function setUpBeforeClass()
	// {
	// 	//self::$attributeStatic = 'StaticTest';
	// 	self::setStaticAttribute('testing');
	// 	echo self::$attributeStatic;

	// }
  	public static function setUpBeforeClass()
    {
    	$kernel = self::getKernelClass();
        self::$kernel = new $kernel('dev', true);
        self::$kernel->boot();	

		self::$container = self::$kernel->getContainer();
    }

    public function get($serviceId)
    {
        return self::$kernel->getContainer()->get($serviceId);
    }

	public function getStaticAttribute()
	{
		return self::$attributeStatic;
	}

	public function setStaticAttribute($value)
	{
		// echo $this->getValues();
		// echo "HELLO: ".$this->atributo;
		self::$attributeStatic = $value;
		echo self::$attributeStatic;
	}

	protected function getValues()
	{
		return 'values from Class';
	}
    public function testIndex()
    {
    	//$this->get('admin.pool');

    	echo $this->getStaticAttribute();
    	// $this->setStaticAttribute('Nuevo valor');

    	// echo self::$attributeStatic;

        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
