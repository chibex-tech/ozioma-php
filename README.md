# ozioma-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP API wrapper for [Ozioma](https://ozioma.net/).

[![Ozioma](img/ozioma.png?raw=true "Ozioma")](https://ozioma.net/)

## Requirements
- Curl 7.34.0 or more recent (Unless using Guzzle)
- PHP 5.4.0 or more recent
- OpenSSL v1.0.1 or more recent

## Install

### Via Composer

``` bash
    $ composer require chibex/ozioma-php
```

### Via download

Download a release version from the [releases page](https://github.com/chibex-tech/ozioma-php/releases).
Extract, then:
``` php
    require 'path/to/src/autoload.php';
```

## IMPORTANT
This is the first implementation of Ozioma API version 2.

## Usage

Instantiate Ozioma class and pass you ACCESS-KEY as an argument to the construct. The you can can start calling resource methods to fulfill your requests

### 0. Prerequisites
Confirm that your server can conclude a TLSv1.2 connection to Ozioma's servers. Most up-to-date software have this capability. Contact your service provider for guidance if you have any SSL errors.

### 1. Initiate sending message
When you submit message for sending our server queue's the message for delivery and after delivery your callback url is called to notify your system/website that your message has been sent.

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response = $ozioma->message->send(['sender' => 'php lib',
                                        'message' => 'it is awesome',
                                        'recipients' => '23470xxxxxxxx',
                                        'use_corporate_route' => true, // [true or false]
                                        'callback_url' => 'http://your-website/your-callback-url',  
                                        ]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```
#### send method parameters
- `sender` is your custom name/title for your message and is should not exceed 11 characters (space is also counted as character)
- `message` is the content you want to send to your recipient(s)
- `use_corporate_route` cant either be true or false. Value 'true' means that you want your message delivers to Do-Not-disturb (DND) numbers for countries that has dnd policy
- `callback_url` When you submit message for sending our server queue's the message for delivery and after delivery your callback url is called to notify your system/website that your message has been sent. Then you can use the message id passed as query string to retrieve delivery details. This parameter is optional in case you don't want to receive callback


### 2. Scheduling message
Most of the parameter are the same with `send` method above.

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response = $ozioma->message->schedule(['sender' => 'php lib',
                                    'message' => 'it is awesome',
                                    'recipients' => '23470xxxxxxxx',
                                    'use_corporate_route' => true,
                                    'callback_url' => 'http://your-website/your-callback-url',
                                    'extras' => [[
                                        'deliver_at' => '2019-07-23 10:10',
                                        'time_zone_id' => 2,
                                    ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

- `extras` accepts arrays of delivery times, in case you want your scheduled message to deliver at different times.
- `time_zone_id` You can call our time zone endpoint to get list of timezones and their ids. It's used to set at what timezone you want your scheduled message to delivery to your recipient(s)

### 3. Add Subscriber to your Newsletter list
To add subscriber from your system/website to your Newsletter list, first login to your Ozioma dashboard and create the newsletter list. Next call Newsletter endpoint to pull your list with their ids

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response =  $ozioma->newsletter->addSubscriber([
                                    'id' => 2,
                                    'name' => 'Chibuike Mba',
                                    'phone_no' => '23470xxxxxxxx']);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 4. Add Subscribers to your Newsletter list
This is same as adding single subscriber but in this case you add multiple subscribers at once

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response =  $ozioma->newsletter->addBulkSubscribers([
                                        'id' => 2,
                                        'subscribers' => [[
                                            'name' => 'Izuchukwugeme Okafor',
                                            'phone_no' => '23470xxxxxxxx'
                                        ],[
                                            'name' => 'Franklin Nnakwe',
                                            'phone_no' => '23480xxxxxxxx'
                                        ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 5. Add Birthday Contact to your Birthday group
To add contact from your system/website to your birthday group, first login to your Ozioma dashboard and create the birthday group. Next call Birthday endpoint to pull your groups with their ids

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response =  $ozioma->birthday->addContactToGroup([
                                        'group_id' => 7,
                                        'name' => 'Dennis Okonnachi',
                                        'phone_no' => '23470xxxxxxxx',
                                        'day' => 9,
                                        'month_id' => 1,
                                    ]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

### 6. Add Birthday Contacts to your Birthday group
This is same as adding single contact but in this case you add multiple contacts at once

```php
    $ozioma = new Chibex\Ozioma(ACCESS-KEY);
    try
    {
        $response =  $ozioma->birthday->addBulkContactsToGroup([
                                        'group_id' => 7,
                                        'contacts' => [[
                                            'name' => 'Calab',
                                            'phone_no' => '23470xxxxxxxx',
                                            'day' => 9,
                                            'month_id' => 1,
                                        ]]]);
        var_dump($response);

    } catch(\Chibex\Ozioma\Exception\ApiException $e){
        print_r($e->getResponseObject());
        die($e->getMessage());
    }
```

## 5. Closing Notes

Generally, to make an API request after constructing a ozioma object, Make a call
 to the resource/method thus: `$ozioma->{resource}->{method}()`; for gets,
  use `$ozioma->{resource}(id)` and to list resources: `$ozioma->{resource}s()`.

Currently, we support: 'message', 'newsletter', 'birthday', 'month', 'balance' and 'timezones'. Check
our API reference([link-ozioma-api-reference][link-ozioma-api-reference]) for the methods supported. To specify parameters, send as an array.

Check [SAMPLES](SAMPLES.md) for more sample calls

### MetadataBuilder

This class helps you build valid json metadata strings to be sent when making transaction requests.
```php
    $builder = new MetadataBuilder();
```

#### Add metadata

To turn off automatic snake-casing of Key names, do:

```php
    MetadataBuilder::$auto_snake_case = false;
```

before you start adding metadata to the `$builder`.

#### Build JSON

Finally call `build()` to get your JSON metadata string.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
    $ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CONDUCT.md) for details. Check our [todo list](TODO.md) for features already intended.

## Security

If you discover any security related issues, please email chibexme@gmail.com instead of using the issue tracker.

## Credits

- [Chibex Technologies][link-author]
- [Chibuike Mba](https://github.com/chibexme)
- [Yabaconn](https://github.com/yabacon/paystack-php) - followed the style he employed in creating the [Paystack PHP Wrapper](https://github.com/yabacon/paystack-php)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/chibex/ozioma-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/chibex-tech/ozioma-php/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/chibex-tech/ozioma-php.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/chibex-tech/ozioma-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/chibex/ozioma-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/chibex/ozioma-php
[link-travis]: https://travis-ci.org/chibex-tech/ozioma-php
[link-scrutinizer]: https://scrutinizer-ci.com/g/chibex/ozioma-php/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/chibex/ozioma-php
[link-downloads]: https://packagist.org/packages/chibex/ozioma-php
[link-author]: https://github.com/chibex-tech
[link-contributors]: ../../contributors
[link-ozioma-api-reference]: https://developers.ozioma.net/reference
