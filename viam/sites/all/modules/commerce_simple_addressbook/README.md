## Commerce Simple Addressbook

This module provides a simplified address book for customers.

There are several inherent issues that commerce_addressbook has which this module sets out to fix by simplifying the whole process of allowing customers to select an existing address from their profile. It works works by setting the customer profile form values instead of trying to attach an existing profile to a new order.

**Differences in this module and commerce_addressbook**
* Doesn't attempt to reassign existing profiles to new orders, just populates the form fields in form state.
* Clones a saved profile entered during checkout so that it is not associated with an order and can be edited or deleted at any time.
* Does not trigger an order save when selecting address book entries during checkout. See #1804592: During AJAX form submission in checkout, the $order argument passed by the Form API is incorrect.
* Prevents duplicate profiles from being created by disabling the ability to save an address book selection
* Provides a simplified /user/%user/addressbook menu callback for users to manage their profiles
* I'm open to adding additional features, but the goal is to KISS!

**I'm open to adding additional features, but the goal is to KISS!**

## Installation

If you're already using commerce_addressbook, make sure that it is removed before
enabling this module.

1) Add to any Drupal Commerce site and enable!
2) Set "Edit own customer profiles of any type" and "View own customer profiles of any type" permissions for authenticated users so that customers can manage their address book profiles.

Report issues to https://www.drupal.org/project/issues/commerce_simple_addressbook
