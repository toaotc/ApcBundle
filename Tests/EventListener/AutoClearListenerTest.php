<?php

namespace Toa\Bundle\ApcBundle\Tests\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Toa\Bundle\ApcBundle\EventListener\AutoClearListener;

/**
 * AutoClearListenerTest
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class AutoClearListenerTest extends \PHPUnit_Framework_TestCase
{
    private $listener;
    private $cacheDir;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if ((!extension_loaded('apc'))) {
            $this->markTestSkipped('Apc is not loaded');
        }

        $this->cacheDir = sys_get_temp_dir();
        @unlink($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        @unlink($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->listener = null;
        @unlink($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        @unlink($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');
    }

    /**
     * @test
     */
    public function testGetSubscribedEventsReturnArray()
    {
        $this->assertInternalType('array', AutoClearListener::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function testDefault()
    {
        $this->listener = new AutoClearListener($this->cacheDir);

        $event = $this->getEvent(HttpKernelInterface::SUB_REQUEST);
        $this->listener->onKernelRequest($event);

        $event = $this->getEvent(HttpKernelInterface::MASTER_REQUEST);
        $this->listener->onKernelRequest($event);

        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');
    }

    /**
     * @test
     */
    public function testUserIsTrue()
    {
        $this->listener = new AutoClearListener($this->cacheDir, true);

        $event = $this->getEvent(HttpKernelInterface::SUB_REQUEST);
        $this->listener->onKernelRequest($event);

        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');

        $event = $this->getEvent(HttpKernelInterface::MASTER_REQUEST);
        $this->listener->onKernelRequest($event);

        $this->assertFileExists($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');
    }

    /**
     * @test
     */
    public function testOpcodeIsTrue()
    {
        $this->listener = new AutoClearListener($this->cacheDir, false, true);

        $event = $this->getEvent(HttpKernelInterface::SUB_REQUEST);
        $this->listener->onKernelRequest($event);

        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');

        $event = $this->getEvent(HttpKernelInterface::MASTER_REQUEST);
        $this->listener->onKernelRequest($event);

        $this->assertFileNotExists($this->cacheDir . DIRECTORY_SEPARATOR . 'user');
        $this->assertFileExists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode');
    }

    private function getEvent($requestType)
    {
        $kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $request = new Request();
        $event = new GetResponseEvent($kernel, $request, $requestType);

        return $event;
    }
}
