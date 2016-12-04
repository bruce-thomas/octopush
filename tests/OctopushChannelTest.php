<?php

namespace NotificationChannels\Octopush\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use NotificationChannels\Octopush\OctopushChannel;
use NotificationChannels\Octopush\OctopushClient;
use NotificationChannels\Octopush\OctopushMessage;
use Octopush\Api\Client as OctopushApiClien;
use NotificationChannels\Octopush\Exceptions\CouldNotSendNotification;

class OctopushChannelTest extends \PHPUnit_Framework_TestCase
{
    private $config = ['user_login' => '***', 'api_key' => '***'];

    private $message;

    private $thirdPartyClient;

    private $client;

    private $channel;

    public function setUp()
    {
        parent::setUp();

        // $this->thirdPartyClient = Mockery::mock(OctopushApiClient::class);
        $this->client = new OctopushClient($this->config);
        $this->channel = new OctopushChannel($this->client);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_should_throw_exception_when_credentials_are_missing()
    {
        $notifiable = new TestNotifiable();
        $notification = new TestNotification();
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send($notifiable, $notification);
    }
}

class TestNotifiable
{
    public function routeNotificationFor()
    {
        return '+011223344';
    }
}

class TestNotifiableWithoutRecipient
{
    public function routeNotificationFor()
    {
    }
}

class TestNotifiableWithDefaultAttribute
{
    public $phone_number = '+011223344';
}

class TestNotification extends Notification
{
    public function toOctopush()
    {
        return (new OctopushMessage)
            ->from('A sender')
            ->content('A message');
    }
}
