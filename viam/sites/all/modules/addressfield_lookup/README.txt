INTRODUCTION
------------
This module provides an abstracted API for providing address field lookup
services. The module relies on the Address Field module
(https://www.drupal.org/project/addressfield) for its underlying architecture.
The scope of this module is to provide an addressfield handler that will
provide postcode lookup functionality based on the default lookup service.

ADDRESS FIELD LOOKUP SERVICES
-----------------------------
Address Field Lookup services can be defined through the module API, the main
entry point for this being hook_addressfield_lookup_service_info. Documentation
can be found in addressfield_lookup.api.php. Each service needs to provide its
own handler class which implements the AddressFieldLookupInterface defined
within addressfield_lookup.interface.inc file of this module.

To create your own services refer to the API documentation and the interface.
There is also an example module in the tests/modules/addressfield_lookup_example
folder. While intended for unit testing this is also useful as a reference
implementation.

Each service is required to provide its own configuration interface via the
form API. The actual details of the configuration can be fully bespoke to the
service.

This module ships with the following services by default (via sub-modules):

  * PCA Predict (Formerly Postcode Anywhere)

API CHANGES
-----------
Since the initial release of this module there have been breaking API changes.
These will cause existing integrations with the Address Field Lookup API to
break. For more details please see API.txt

REQUIREMENTS
------------
This module requires the following modules:
  * Address Field (https://drupal.org/project/addressfield)
  * Chaos tool suite (https://drupal.org/project/ctools)

INSTALLATION
------------
  * Enable the Address Field Lookup module.
  * Clear cache.

CONFIGURATION
-------------
Configuration for the module can be found at the following URL:

admin/config/regional/addressfield-lookup

This configuration page will allow to view all currently available address
lookup services. You can choose the default service and configure each of the
services individually.

All addressfield instances will have an 'Address Field Lookup' handler
available.

The module also defines the following permissions which can be found at
Administration » People » Permissions:

  * Administer Address Field Lookup Services

    Manage the settings for address field lookup services.

MAINTAINERS
-----------
Current maintainers:
  * Dan Richards - https://www.drupal.org/user/3157375

This project has been sponsored by:
  * LUSH Digital - https://www.drupal.org/node/2529922
    In order for us to become a company of the future and clear cosmetic leader
    we are putting the internet at the heart of our business. It's time for Lush
    to be at the forefront of digital and revolutionise the cosmetics industry.

    Lush Digital enables technology to connect people throughout our community
    and build relationships bringing customer to the heart of our business.
  * FFW - https://www.drupal.org/marketplace/FFW
    FFW is a digital agency built on technology, driven by data, and focused on
    user experience.

ACKNOWLEDGEMENTS
----------------
Huge thank you to the developers/sponsors of the 'Postcodeanywhere Addressfield'
module (https://www.drupal.org/project/postcodeanywhere_addressfield). This
module is based on the concepts outlined there and without it my life would
have been much harder!

Postcodeanywhere Addressfield developers and sponsors:

  * Yuriy Gerasimov (https://www.drupal.org/u/ygerasimov)
  * Commerce Guys (https://commerceguys.com/)
  * iKOS (http://www.i-kos.com/)
