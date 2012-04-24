SimpleMQAdminGeneratorBundle 
============================

This Bundle is a easy way to get full Admin section in your app , mapping all needed entities using services 
as Sonata Admin does. All those entities are tagged as admin.pool, where admin.pool is the master piece in 
AdminGeneratorBundle , being hooked by admin.pool service on SimpleMQAdminGenerator , and managed them by a 
complete CRUD on admin backend.

Actually this bundle is completelly functional, but has lots of details that has to be fixed, so you can say that
is in Pre Release state.

By default entities are mapped in all CRUD views with all his fields , but if you prefer it you can customize them
overriding number of form , grid, list fields, by extending Admin Class in your own Bundle.
Redefining them is as easy as Symfony 2 does, so you are able to define standard forms to be used in your Admin Area. 

Actually CRUDController is implemented as a service , being decoupled from Original Controller Class has 
lots of benefits as injecting all depending services in class controller.

Twitter Bootstrap has been included in all templates in order the get a nice look.

This project has been developed as a way to improve my knowledge on Symfony 2 services , so it's just a toy project ;)

Installation Details
====================

##At the end of your deps file add:
```
[SimpleMQAdminGeneratorBundle]
    git=http://github.com/marcosQuesada/SimpleMQAdminGeneratorBundle.git
    target=/bundles/SimpleMQ/AdminGeneratorBundle
```
##Run ./bin/vendors install 

##Register SimpleMQAdminGeneratorBundle in AppKernel
``` 
AppKernel.php
  new SimpleMQ\AdminGeneratorBundle\SimpleMQAdminGeneratorBundle(),
```

##Add autoloader entry:
``` 
autoload.php
  'SimpleMQ'         => __DIR__.'/../vendor/bundles',   
```

##Add admin route in routing.yml
```
SimpleMQAdminGeneratorBundle:
    resource: "@SimpleMQAdminGeneratorBundle/Resources/config/routing.yml"
    prefix:   /admin
```
##Append to config.yml
```
simple_mq_admin_generator:
    title:       Simple Admin Generator
    base_route:  admin   
```

After this step installation process has finished. 

Map your entities
=================

You can see a sandbox deploy here: 
  https://github.com/marcosQuesada/SimpleMQ-Admin-Generator-Bundle--SANDBOX--under-development

 To map your entities create a service in that way :
```
services:
   acme_base.core.admin.location:
      class: Acme\BaseBundle\Admin\LocationAdmin
      tags:
        - { name: admin.pool }
      arguments:         
        -  [Acme\BaseBundle\Entity\Location]
```

Create an Admin Folder inside your base bundle, you need to add one Admin file by mappedEntity:
```
<?php
namespace Acme\BaseBundle\Admin;

use SimpleMQ\AdminGeneratorBundle\Admin\Admin as Base;

class LocationAdmin extends Base
{

}
```
Extendind Admin Class you can customize your CRUD screens, removing any entity field in forms, grid, list ...
You can take a look to vendor/bundles/SimpleMQ/AdminGeneratorBundle/Admin/Admin.php where Admin Class is located.

Any suggest will be appreciated , for sure Pull Request too ;D
