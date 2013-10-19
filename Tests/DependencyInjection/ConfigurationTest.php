<?php

namespace Toa\Bundle\ApcBundle\Test\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Toa\Bundle\ApcBundle\DependencyInjection\Configuration;

/**
 * ConfigurationTest
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Configuration */
    private $configuration;

    /** @var Processor */
    private $processor;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    /**
     * @test
     */
    public function testAutoClearIsNull()
    {
        $config = array('toa_apc' => array());
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertArrayHasKey('auto_clear', $configs);
        $this->assertEquals(false, $configs['auto_clear']['user']);
        $this->assertEquals(false, $configs['auto_clear']['opcode']);
    }

    /**
     * @test
     */
    public function testAutoClearIsFalse()
    {
        $config = array('toa_apc' => array('auto_clear' => false));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(false, $configs['auto_clear']['user']);
        $this->assertEquals(false, $configs['auto_clear']['opcode']);
    }

    /**
     * @test
     */
    public function testAutoClearIsTrue()
    {
        $config = array('toa_apc' => array('auto_clear' => true));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(true, $configs['auto_clear']['user']);
        $this->assertEquals(true, $configs['auto_clear']['opcode']);
    }

    /**
     * @test
     */
    public function testUserIsNull()
    {
        $config = array('toa_apc' => array('auto_clear' => array()));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(false, $configs['auto_clear']['user']);
    }

    /**
     * @test
     */
    public function testUserIsFalse()
    {
        $config = array('toa_apc' => array('auto_clear' => array('user' => false)));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(false, $configs['auto_clear']['user']);
    }

    /**
     * @test
     */
    public function testUserIsTrue()
    {
        $config = array('toa_apc' => array('auto_clear' => array('user' => true)));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(true, $configs['auto_clear']['user']);
    }

    /**
     * @test
     */
    public function testOpcodeIsNull()
    {
        $config = array('toa_apc' => array('auto_clear' => array()));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(false, $configs['auto_clear']['user']);
    }

    /**
     * @test
     */
    public function testOpcodeIsFalse()
    {
        $config = array('toa_apc' => array('auto_clear' => array('opcode' => false)));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(false, $configs['auto_clear']['opcode']);
    }

    /**
     * @test
     */
    public function testOpcodeIsTrue()
    {
        $config = array('toa_apc' => array('auto_clear' => array('opcode' => true)));
        $configs = $this->processor->processConfiguration($this->configuration, $config);

        $this->assertEquals(true, $configs['auto_clear']['opcode']);
    }
}
