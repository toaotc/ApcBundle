ToaApcBundle
============

This Bundle clears the APC cache on the very request after cache warmup.

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
        prefix: sf2 #default

The `toa_apc.prefix` must be the same you set in `web/app.php`:

    // web/app.php
    // ...
    $loader = new ApcClassLoader('sf2', $loader);
    $loader->register(true);
    // ...
