
# Octopush Notifications Channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/octopush.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/octopush)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/octopush/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/octopush)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/octopush.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/octopush)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/octopush/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/octopush/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/octopush.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/octopush)

This package makes it easy to send notifications using [Octopush](http://www.octopush.com/en/home) with Laravel 5.3.

## Contents

- [Installation](#installation)
	- [Setting up the Octopush service](#setting-up-the-octopush-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install the package via composer :

```bash
composer require laravel-notification-channels/octopush
```

Register the service provider in your `config/app.php` configuration file :

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Octopush\OctopushServiceProvider::class,
],
```

Set up the Octopush service as explained below.

### Setting up the Octopush service

Register a free trial account from [Octopush website](http://www.octopush.com/en/registration) (offering 5 SMS for free) .

Get your credentials from your Octopush account, and add them to your `config/services.php` configuration file :

```php
// config/services.php
...
'octopush' => [
    'user_login' => '**********@*******',
    'api_key' => '****************',
],
...
```
The table below shows a complete list of all available configuration parameters :

Parameter name | Description
:--------------|:-----------
**`user_login`** | User login (email address used for registration). **This parameter is mandatory.**
**`api_key`** | API key available on your Octopush manager. **This parameter is mandatory.**
`sms_text` | SMS message text (maximum 459 characters).
`sms_type` | SMS type : `XXX` for low cost SMS, `FR` for Premium SMS (France only), and `WWW` for  global worldwide SMS (default value). In France, if `STOP XXXXX` is missing from your message text, the API will return an error.
`sms_sender` | Sender of the message (if supported by the recipient mobile phone operator), containing from 3 to 11 alphanumeric characters only.
`request_mode` | Allows to enable a simulation mode with the value `simu`. In the simulation mode, the API calls are done, but no SMS are sent. The default value is `real` (simulation mode is disabled by default).

For a better convenience, parameter names match the ones used by Octopush SMS API, which are described at the following URL :
[http://www.octopush.com/en/api-sms-doc/parameters](http://www.octopush.com/en/api-sms-doc/parameters).

## Usage

You can use the channel in the `via()` method inside the notification class, and format the notification message within the `toOctopush()` method :

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Octopush\OctopushMessage;
use NotificationChannels\Octopush\OctopushChannel;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [OctopushChannel::class];
    }

    public function toOctopush($notifiable)
    {
        return (new OctopushMessage)
            ->from('Online Store')
            ->content('Your invoice has been paid.');
    }
}
```

The notification channel will automatically look for a `phone_number` attribute on the notifiable entity. If you would like to customize the phone number the notification is delivered to, define a `routeNotificationForOctopush` method on the entity:

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Route notifications for Octopush channel.
     *
     * @return string
     */
    public function routeNotificationForOctopush()
    {
        return $this->phone;
    }
}
```

The `routeNotificationForOctopush()` method must return a valid phone number, in international format. It can also return an array of phone numbers :

```php
// Notifiable entity

    /**
     * Route notifications for Octopush channel.
     *
     * @return string
     */
    public function routeNotificationForOctopush()
    {
        return [$this->professional_phone_number, $this->personal_phone_number];
    }
```

For further information about notification usage, you can read the official [documentation about Laravel notification system](https://laravel.com/docs/master/notifications).

### Available Message methods

The notification can be customized with the following methods (see `OctopushMessage` class):

- `content(string $text)`: Set the notification message.
- `from(string $sender)`: Set the sender name.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Troubleshooting

Octopush provides a list of error codes returned by the service : [http://www.octopush.com/en/errors_list](http://www.octopush.com/en/errors_list).

For further information, you can also read the documentation of the [Octopush SMS API Client](https://github.com/octopush/sms-api-php), which is used by this notification system.

## Security

If you discover any security related issues, please email brucethomas.fr@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Bruce Thomas](https://github.com/bruce-thomas)
- [Octopush organisation](https://github.com/octopush) and [umpirsky](https://github.com/umpirsky) for developing [the SMS API client](https://github.com/octopush/sms-api-php)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
