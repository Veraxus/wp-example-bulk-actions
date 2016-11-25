# Example Bulk Actions Plugin
**Requires WordPress 4.7+**

This plugin demonstrates how to add a custom bulk action to any admin screen. Custom bulk actions are a new developer feature introduced in WordPress 4.7

## Overviewffdfsf
Each hook is passed the following arguments:
Bulk actions can be added to the list table for any screen using the hook `bulk_actions-{$screen_id}`, but this alone isn't enough to handle the action or display a custom message once the action is processed.

### Handling Custom Actions
Custom bulk actions are handled using the `handle_bulk_actions-{$screen_id}` and `handle_network_bulk_actions-{$screen_id}` hooks.

* `$sendback`
A s
