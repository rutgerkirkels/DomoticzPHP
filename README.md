#domoticz-php
Library for connecting to Domoticz

With this library you can control lights, switches, thermostats and other home automation devices with PHP by connecting to [Domoticz](http://domoticz.com), the open-source Home Automation System.

**Installation**
> php composer.phar require rutgerkirkels/domoticz-php

**Basic usage**

```php
// Initialize the Domoticz library with the hostname of the Domoticz machine.
// If you didn't set login credentials, you can leave the username and password
// attributes empty.

$client = new \rutgerkirkels\DomoticzPHP\Client('http://192.168.20.204:8080');

// Get all lights and switches
$lightsAndSwitches = $client->getDevices('light');

// Get the status of a device
$device = $client->getDeviceByIdx(<idx>);
echo $device->getStatus();

// When the device is a dimmer, get the current set level in percentages (return false of not a dimmer)
$level = $device->getLevel();

// Initiate a controller for this dimmer
$dimmerController = (new \rutgerkirkels\DomoticzPHP\Factories\ControllerFactory($device))->get();

// and turn it on...
$dimmerController->turnOn();

// and off again...
$dimmerController->turnOff();
```
Domoticz-php also offers the ability to pre-define home automation appliances through a YAML-config file, so that you can use appliances that consist of multiple sensors and switches, like a Nest Thermostat.