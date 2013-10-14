<?php

namespace Toa\Bundle\ApcBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApcListener implements EventSubscriberInterface
{
    /** @var string */
    private $cacheDir;

    /** @var string */
    private $prefix;

    public function __construct($cacheDir, $prefix)
    {
        $this->cacheDir = $cacheDir;
        $this->prefix = $prefix;
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

        if (file_exists($this->cacheDir . DIRECTORY_SEPARATOR . $this->prefix)) {
            return;
        }

        apc_clear_cache($this->prefix);

        file_put_contents($this->cacheDir . DIRECTORY_SEPARATOR . $this->prefix, time());
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
