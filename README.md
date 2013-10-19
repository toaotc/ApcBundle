ToaApcBundle
============

This Bundle clears the APC cache on the very first request after cache warmup.

[build]: https://travis-ci.org/toaotc/ApcBundle
[coverage]: https://scrutinizer-ci.com/g/toaotc/ApcBundle/
[quality]: https://scrutinizer-ci.com/g/toaotc/ApcBundle/
[package]: https://packagist.org/packages/toa/apc-bundle
[dependency]: https://www.versioneye.com/user/projects/5262f16c632bac5e8600000a
[sensiolabsinsight]: https://insight.sensiolabs.com/projects/ba2e2adc-f099-4b82-9411-7417e3b167a5

[![Build Status](https://travis-ci.org/toaotc/ApcBundle.png)][build]
[![Code Coverage](https://scrutinizer-ci.com/g/toaotc/ApcBundle/badges/coverage.png?s=0587d9d52d2c16a425b64935c4deb955fa0e90f4)][coverage]
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/toaotc/ApcBundle/badges/quality-score.png?s=c3da9324d7449cbcadfadf91553a8b5f722af90a)][quality]
[![Dependency Status](https://www.versioneye.com/user/projects/5262f16c632bac5e8600000a/badge.png)][dependency]

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ba2e2adc-f099-4b82-9411-7417e3b167a5/mini.png)][sensiolabsinsight]
[![Latest Stable Version](https://poser.pugx.org/toa/apc-bundle/v/stable.png "Latest Stable Version")][package]
[![Total Downloads](https://poser.pugx.org/toa/apc-bundle/downloads.png "Total Downloads")][package]

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
        auto_clear:
            opcode: true # system cache
            user:   true # user cache
