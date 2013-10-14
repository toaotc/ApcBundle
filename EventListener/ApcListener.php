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
class ApcListener implements EventSubscriberInterface
{
    /** @var string */
    private $cacheDir;

    /**
     * @param string $cacheDir
     */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        if (!extension_loaded('apc')) {
            return;
        }

        if (file_exists($this->cacheDir . DIRECTORY_SEPARATOR . 'user')) {
            return;
        }

        apc_clear_cache('user');

        file_put_contents($this->cacheDir . DIRECTORY_SEPARATOR . 'user', time());
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
