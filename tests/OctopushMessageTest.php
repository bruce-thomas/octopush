<?php

namespace NotificationChannels\Octopush\Test;

use Illuminate\Support\Arr;
use NotificationChannels\Octopush\OctopushMessage;

class OctopushMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Octopush\OctopushMessage */
    private $message;

    public function setUp()
    {
        parent::setUp();
        $this->message = new OctopushMessage();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $message = new OctopushMessage();
        $this->assertInstanceOf(OctopushMessage::class, $message);
    }

    /** @test */
    public function it_can_accept_a_content_when_instantiated()
    {
        $message = new OctopushMessage('A message');
        $this->assertEquals('A message', Arr::get($message->toArray(), 'content'));
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $this->message->content('A message');
        $this->assertEquals('A message', Arr::get($this->message->toArray(), 'content'));
    }

    /** @test */
    public function it_can_set_the_sender()
    {
        $this->message->from('A sender');
        $this->assertEquals('A sender', Arr::get($this->message->toArray(), 'from'));
    }
}
