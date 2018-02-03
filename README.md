#domoticz-php
Library for connecting to Domoticz

With this library you can control lights, switches, thermostats and other home automation devices with PHP by connecting to [Domoticz](http://domoticz.com), the open-source Home Automation System.

**Installation**
> php composer.phar require rutgerkirkels/domoticz-php

**Basic usage**

```php

<?php

// Initialize the Domoticz library with the hostname of the Domoticz machine.
// If you didn't set login credentials, you can leave the username and password
// attributes empty.
$domoticz = new \rutgerkirkels\domoticz_php\Domoticz('<hostname>','<username>', '<password>');

/**
 * This example reads the temperature from the first temperature sensor that is found
 */

// Get all the temperature sensors in Domoticz
$temperatureSensors = $domoticz->getTemperatureDevices();

// Get the temperature from the first sensor
echo $temperatureSensors[0]->Name() . ' temperature is ' . $temperatureSensors[0]->Temp();
?>
```
**Another example: Read the status of the first light/switch that is found in Domoticz:**

```php
<?php
$lightsAndSwitches = $domoticz->getLightsAndSwitches();
echo 'Status of ' . $lightsAndSwitches[0]->Name() . ': ' . $lightsAndSwitches[0]->Status();
?>
```
Domoticz-php also offers the ability to pre-define home automation appliances through a YAML-config file, so that you can use appliances that consist of multiple sensors and switches, like a Nest Thermostat.