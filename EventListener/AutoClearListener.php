<?php

namespace Toa\Bundle\ApcBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * ApcListener
 *
 * @author Enrico Thies <enrico.thies@gmail.com>
 */
class AutoClearListener implements EventSubscriberInterface
{
    /** @var string */
    private $cacheDir;

    /** @var boolean */
    private $clearUser;

    /** @var boolean */
    private $clearOpcode;

    /**
     * @param string  $cacheDir
     * @param boolean $clearUser
     * @param boolean $clearOpcode
     */
    public function __construct($cacheDir, $clearUser = false, $clearOpcode = false)
    {
        $this->cacheDir = $cacheDir;
        $this->clearUser = $clearUser;
        $this->clearOpcode = $clearOpcode;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$this->clearUser && !$this->clearOpcode) {
            return;
        }

        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        if (!extension_loaded('apc')) {
            return;
        }

        if ($this->clearUser && !file_exists($this->cacheDir . DIRECTORY_SEPARATOR . 'user')) {
            apc_clear_cache('user');
            file_put_contents($this->cacheDir . DIRECTORY_SEPARATOR . 'user', date('r'));
        }

        if ($this->clearOpcode && !file_exists($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode')) {
            apc_clear_cache('opcode');
            file_put_contents($this->cacheDir . DIRECTORY_SEPARATOR . 'opcode', date('r'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 512)
        );
    }
}
