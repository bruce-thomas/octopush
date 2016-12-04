<?php

namespace NotificationChannels\Octopush;

use Illuminate\Support\Arr;

class OctopushMessage
{
    /**
     * @var string The message content.
     */
    public $content;

    /**
     * @var string The phone number the message should be sent from.
     */
    public $from;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get message as array.
     *
     * @return array
     */
    public function toArray()
    {
        $message = [
            'from' => $this->from,
            'content' => $this->content
        ];

        return $message;
    }
}
