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



License
=======
This bundle is under the MIT license. See the complete license in the bundle:
    LICENSE