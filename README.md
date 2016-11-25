# Example Bulk Actions Plugin
**Requires WordPress 4.7+**

This plugin demonstrates how to add a custom bulk action to any admin screen. Custom bulk actions are a new developer feature introduced in WordPress 4.7

## Overview
Each hook is passed the following arguments:
Bulk actions can be added to the list table for any screen using the hook `bulk_actions-{$screen_id}`, but this alone isn't enough to handle the action or display a custom message once the action is processed.

## Handling Custom Actions
Custom bulk actions are handled using the `handle_bulk_actions-{$screen_id}` and `handle_network_bulk_actions-{$screen_id}` hooks.

It's important to know that once WordPress handles a list table action it performs a redirect, using only a querystring parameter to trigger the display of a message. The hook is also structured in such a way that you are not able to modify any WordPress built-in actions. Only your own custom actions can be handled.

With this in mind, the above hooks take the following arguments...

* `$sendback` : String. The URL to redirect to once the action is complete. Use `add_query_arg()` to modify this, if desired.
* `$action` : String. The name of the action currently being performed. This allows you to test for your custom action.
* `$items` : Array. An array of the items being handled by the bulk action.
* `$site_id` : Int. This only applies to the network bulk action hook and only for WordPress Multisite. It includes the id of the site being modified.

## Displaying Messages
To display a message, you need to use `add_query_arg()` inside your bulk action handler to add one or more arguments to the redirect querystring. You can then test for your custom argument(s) inside the `admin_notices` and/or `network_admin_notices` hooks, and display an appropriate message.

Don't forget to use `remove_query_arg()` inside the `current_screen` hook too, or your message will not automatically disappear if the user takes other actions.
