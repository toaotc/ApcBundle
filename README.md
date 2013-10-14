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

## Configuration ##

Set the bundle's configuration in `app/config/config.yml`:

    # app/config/config.yml
    toa_apc:
        clear_on_cache_warmup: false #default
