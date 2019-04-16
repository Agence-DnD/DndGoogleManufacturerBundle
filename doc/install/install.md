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
        "agencednd/google-manufacturer-connector-bundle": "1.0.*"
    }
}
```
And finish the install by running: 
```bash
cd /my/pim/installation/dir
composer install
```

##### [> Back to summary](../summary.md)