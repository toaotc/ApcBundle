<?php

namespace Toa\Bundle\ApcBundle\Tests;

/**
 * AutoClearContainerTest
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class AutoClearContainerTest extends ContainerTest
{
    protected function tearDown()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => true)));

        $cacheDir = $container->getParameter('toa_apc.cache_dir');
        rmdir($cacheDir);
    }

    /**
     * @test
     */
    public function testIsNullConfiguration()
    {
        $container = $this->createContainer(array());

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testIsFalseConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => false)));

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testIsTrueConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => true)));

        $this->assertTrue($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testUserIsNullConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('user' => null))));

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testUserIsFalseConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('user' => false))));

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testUserIsTrueConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('user' => true))));

        $this->assertTrue($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testOpcodeIsNullConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('opcode' => null))));

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testOpcodeIsFalseConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('opcode' => false))));

        $this->assertFalse($container->hasDefinition('toa_apc.apc_listener'));
    }

    /**
     * @test
     */
    public function testOpcodeIsTrueConfiguration()
    {
        $container = $this->createContainer(array('toa_apc' => array('auto_clear' => array('opcode' => true))));

        $this->assertTrue($container->hasDefinition('toa_apc.apc_listener'));
    }
}
