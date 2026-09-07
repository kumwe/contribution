# Standalone consumer

Run `php examples/typed-consumer.php` after Composer installation in this checkout.

Run `php vendor/kumwe/contribution/examples/typed-consumer.php vendor/autoload.php` when installed as a dependency. An explicit invalid autoloader fails without selecting a fallback.

The example declares one immutable definition, registers it under an explicit dotted policy, verifies exact-owner lookup and removes the owner. No host or container is needed.
