# Upgrade Guide 

_How do I upgrade an existing Pletfix application._

- [Upgrading from 0.7.3](#0.7.3)

<a name="0.7.3"></a>
## Upgrading from 0.7.3 to 0.7.4

This section describes what has changed from version 0.7.3 to version 0.7.4.

Add this entry to `boot/services.php` (preferably below the comment "Multiple Instance"):

    $di->set('http-client', \Core\Services\HttpClient::class, false);

