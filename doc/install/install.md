# Installation guide:

### How to install Google Manufacturer Connector:

If it is not already done, install Akeneo PIM.

If composer is not installed, get composer (with command line):

```bash
cd /my/pim/installation/dir
curl -sS https://getcomposer.org/installer | php
```

Then, you can either require Google Manufacturer Connector using composer:
```bash
cd /my/pim/installation/dir
composer require "agencednd/google-manufacturer-connector-bundle"
```
Or in your composer.json add the following code dependending on your Akeneo PIM version:
```json
{   
    "require": {
        "agencednd/google-manufacturer-connector-bundle": "3.0.*"
    }
}
```
And finish the install by running: 
```bash
cd /my/pim/installation/dir
composer install
```

### How to enable Google Manufacturer Connector:

First, enable the bundle in the Kernel: 
```php
<?php
// > app/AppKernel.php
// [...]

$bundles[] = new Dnd\GoogleManufacturerBundle\DndGoogleManufacturerBundle();
```
Then, add the route of the bundle:
```yml
# > app/config/routing.yml
dnd_google_manufacturer:
    resource: "@DndGoogleManufacturerBundle/Resources/config/routing.yml"
``` 
Change or add the configuration for media caching:
```yml
# > app/config/config.yml
liip_imagine:
    filter_sets:
        thumbnail_full:
            quality: 100
            format: jpeg
            filters:
                relative_resize: { scale: 1.0 }
```
You are allowed to change the filter set or change the filter key **thumbnail_full** but changes must also be applied in the linked service: **DndGoogleManufactureBundle/Resources/config/renderers.yml**

Then refresh the assets:
```bash
php bin/console cache:clear --env=prod
php bin/console pim:installer:assets --env=prod
yarn run webpack
```

##### [> Back to summary](../summary.md)