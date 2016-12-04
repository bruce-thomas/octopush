<?php

namespace NotificationChannels\Octopush\Exceptions;

class CouldNotSendNotification extends \Exception
{
    /**
     *
     */
    public static function serviceRespondedWithErrorCode($message)
    {
        return new static($message);
    }

    /**
     *
     */
    public static function serviceRespondedWithStatusCode($message)
    {
        return new static($message);
    }

    /**
     *
     */
    public static function serviceReceivedABadRequest($message)
    {
        return new static($message);
    }
}
