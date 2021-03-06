<?php

namespace PositionalFile\Tests\Type;

use PositionalFile\Type\AbstractType;

class TypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractType
     */
    protected $object;

    protected function setUp()
    {
        parent::setUp();
        $this->object = $this->getMockForAbstractClass('PositionalFile\Type\AbstractType');
        $this->object
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('integer'));
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->object = null;
    }

    public function testSetAndGetLength()
    {
        $this->object->setLength(5);
        $this->assertEquals(5, $this->object->getLength());
    }

    public function testGetName()
    {
        $this->assertEquals('integer', $this->object->getName());
    }

    public function testSetAndGetFormat()
    {
        $format = $this->getMockForAbstractClass('PositionalFile\Format\AbstractFormat');
        $this->object->setFormat($format);
        $this->assertInstanceOf('PositionalFile\Format\FormatInterface', $this->object->getFormat());
    }

    public function testCreate()
    {
        $format = $this->getMockForAbstractClass('PositionalFile\Format\AbstractFormat');
        $this->object->setFormat($format);

        $type = clone $this->object;

        $type::staticExpects($this->any())
            ->method('create')
            ->will($this->returnValue($this->object));

        $this->assertInstanceOf('PositionalFile\Type\TypeInterface', $type);
        $this->assertInstanceOf('PositionalFile\Format\FormatInterface', $type->getFormat());
    }
}