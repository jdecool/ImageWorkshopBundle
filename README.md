# ImageWorkshopBundle

[![Build Status](https://travis-ci.org/jdecool/ImageWorkshopBundle.svg)](https://travis-ci.org/jdecool/ImageWorkshopBundle)
[![Latest Stable Version](https://poser.pugx.org/jdecool/image-workshop-bundle/v/stable.png)](https://packagist.org/packages/jdecool/image-workshop-bundle)

Symfony2 bundle implementing for [ImageWorkshop](https://github.com/Sybio/ImageWorkshop)

## Install

Install the bundle using [composer](https://getcomposer.org):

```json
{
    "require": {
        "jdecool/image-workshop-bundle": "~1.0"
    }
}
```

Enable the extension in your application `AppKernel`:

```php
<?php

public function registerBundles()
{
    $bundles = [
        // ...
        new JDecool\Bundle\ImageWorkshopBundle\ImageWorkshopBundle(),
    ];

    // ...

    return $bundles;
}
```

## Twig filters

```html
<img src="{{ 'path/to/image/file.png'|image_filter('image_format') }}">
```

## Configuration reference

```yaml
image_workshop:
    cache:
        lifetime: 86400 # 1 day
        prefix:   media/cache

    formats: ~
```

## Image format definition

```yaml
image_workshop:
    cache:
        lifetime: 86400 # 1 day
        prefix:   media/cache

    formats:
        thumbnail:
            width:  200
            height: 300

        profile:
            width:  500
            height: 500
```
