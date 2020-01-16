# Configuration guide:

### How to configure Google Manufacturer Connector:

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