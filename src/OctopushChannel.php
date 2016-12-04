<?php

namespace NotificationChannels\Octopush;

use Illuminate\Notifications\Notification;
use Octopush\Api\Exception\RequestException;
use Octopush\Api\Exception\ResponseException;
use Octopush\Api\Exception\ResponseCodeException;
use NotificationChannels\Octopush\Exceptions\CouldNotSendNotification;

class OctopushChannel
{
    /**
     * @var NotificationChannels\OctopushClient The Octopush client instance.
     */
    private $octopush;

    /**
     * Create a new Octopush channel instance.
     *
     * @param NotificationChannels\Octopush\OctopushClient  $octopush
     * @return void
     */
    public function __construct(OctopushClient $octopush)
    {
        $this->octopush = $octopush;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\Octopush\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        // Set SMS recipient(s)
        $to = $notifiable->routeNotificationFor('octopush');
        if (! isset($to)) {
            $to = isset($notifiable->phone_number) ? $notifiable->phone_number : null;
        }
        if (! isset($to)) {
            return;
        }
        $recipients = is_array($to) ? $to : [$to];
        $this->octopush->setSmsRecipients($recipients);

        // Set SMS message
        $message = $notification->toOctopush($notifiable);
        if (is_string($message)) {
            $message = new OctopushMessage($message);
        }

        // Set SMS sender
        if (isset($message->from)) {
            $this->octopush->setSmsSender($message->from);
        }

        // Send the SMS and handle exceptions
        try {
            $response = $this->octopush->send(trim($message->content));
        } catch (RequestException $e) {
            throw CouldNotSendNotification::serviceReceivedBadRequest($e->getMessage());
        } catch (ResponseException $e) {
            throw CouldNotSendNotification::serviceRespondedWithStatusCode($e->getMessage());
        } catch (ResponseCodeException $e) {
            throw CouldNotSendNotification::serviceRespondedWithErrorCode($e->getMessage());
        }
    }
}
