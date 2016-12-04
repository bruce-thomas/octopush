<?php

namespace NotificationChannels\Octopush;

use Illuminate\Support\Arr;
use Octopush\Api\Client as OctopushApiClient;

class OctopushClient extends OctopushApiClient
{
    /**
     * Create a new Octpush client instance.
     */
    public function __construct($config)
    {
        $userLogin = isset($config['user_login']) ? $config['user_login'] : null;
        $apiKey = isset($config['api_key']) ? $config['api_key'] : null;

        parent::__construct($userLogin, $apiKey);

        if (isset($config['sms_text'])) {
            $this->setSmsText($config['sms_text']);
        }
        if (isset($config['sms_type'])) {
            $this->setSmsType($config['sms_type']);
        }
        if (isset($config['sms_sender'])) {
            $this->setSmsSender($config['sms_sender']);
        }
        if (isset($config['request_mode']) && $config['request_mode'] == 'simu') {
            $this->setSimulationMode();
        }
    }

    /**
     * Set the message content.
     */
    public function setSmsText($smsText)
    {
        $this->smsText = $smsText;
    }

    /**
     * Send the notification, and allow a default message content.
     */
    public function send($message = null)
    {
        $smsText = isset($message) ? $message : $this->smsText;

        return parent::send($message);
    }
}
