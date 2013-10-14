ToaApcBundle
============

This Bundle clears the APC cache on the very first request after cache warmup.

## Installation ##

Add this bundle to your `composer.json` file:

    {
        "require": {
            "toa/apc-bundle": "dev-master"
        }
    }

Register the bundle in `app/AppKernel.php`:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Toa\Bundle\ApcBundle\ToaApcBundle(),
        );
    }
