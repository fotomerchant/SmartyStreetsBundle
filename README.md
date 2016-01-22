SmartyStreetsBundle
===================

SmartyStreets Bundle for Symfony 2.

Installation
============

### Step 1: Download the SmartyStreetsBundle

***Using Composer***

Add the following to the "require" section of your `composer.json` file:

```
    "blackknight467/smarty-streets-bundle": "1.*"
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/appKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new blackknight467\SmartyStreetsBundle\SmartyStreetsBundle(),
    );
}
```

### Step 3: Configure the bundle

Add the following configuration to your `app/config/config.yml`:
                                        
```
smarty_streets:
    auth_id: 'your SmartyStreets auth id'
    auth_token: 'your SmartyStreets auth token'
```

Usage
=====

You an use this bundle in two ways.  The first is to use the interfaces provided to map to your existing entities.  
The second is to simply pass text strings to the functions that use them.   

### Using Text Strings

In your controller:
```
  $this->get('blackknight467.smarty_streets')->verifyUSStreetAddressText('1600 Pennsylvania Ave NW, Washington, DC 20500');
```

### Using Interfaces
In your entity:
```
class SampleAddressEntity implements SimpleSmartyStreetsUSAddressInterface
```

In your controller:
```
  $address = new SampleAddressEntity();
  $this->get('blackknight467.smarty_streets')->verifyUSStreetAddress($address);
```

Commands
========
This bundle comes with some symfony console commands so you can test text input:
```
php app/console smartystreets:us-verify {address}
php app/console smartystreets:us-zip-verify {zipcode}
```

License
=======
This bundle is under the MIT license. See the complete license in the bundle:
    LICENSE