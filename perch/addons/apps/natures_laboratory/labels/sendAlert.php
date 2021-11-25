<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

// Require the bundled autoload file - the path may need to change
// based on where you downloaded and unzipped the SDK
include('../../../../../twilio-php-main/src/Twilio/autoload.php');
include('../../../../../twilio_config.php');

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = TWILIO_ACCOUNT_SID;
$token = TWILIO_AUTH_TOKEN;
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+447980131289,++447825090147',
    [
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+447401280958',
        // the body of the text message you'd like to send
        'body' => "A labelling error has occurred. Please speak with production staff."
    ]
);