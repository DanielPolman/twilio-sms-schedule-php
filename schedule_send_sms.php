<?php
// -------- name: schedule_send_sms.php
// -------- version: 1.0
// -------- date: 02.10.2022
// -------- authors: Michael Polman, Daniel Polman
// -------- function: send SMS with Twilio, with users and schedule from imported .csv file (https://github.com/DanielPolman/twilio-sms-schedule-php/blob/main/import_sms_schedule.php)

// setup Twilio SMS array: see https://www.twilio.com/docs/libraries/php
require 'vendor/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console --- use for testing
$account_sid = 'YOURACCOUNTSID';
$auth_token = 'YOURAUTHTOKEN';
$msid = 'YOURMESSAGINGSERVICESID'; // ---- for scheduling you need to set up a messaging service

// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

// Fetch the respondents and 'send at' time
// From a csv file, where the respondents are in the first column, and the 'send at' in the second column.
$file_name = 'NAME_OF_UPLOADED_FILE.csv'; // ---- this is the name of the file you upload using import_sms_schedule.php

$respondent = [];
$datum = [];

$row = 1;

if (($handle = fopen('../uploads/'.$file_name, "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 5000, ";")) !== FALSE) {

            if ($data[0] <> "respondent") {
               $row++;
               $respondent[] = $data[0];
               $datum[] = substr($data[1],0,16).":".strval(rand(0,5)).strval(rand(0,9))."+02:00"; // ---- adds random seconds to prevent exceding max SMS; and timezone (+02:00 for AMS)
            }
        }
}
fclose($handle);

for ($x=1; $x < count($respondent); $x++) {

        $client = new Client($account_sid, $auth_token);

        $client->messages->create(
           // Where to send a text message = number of respondent in your .csv
           $respondent[$x],
           array(
                //'from' => $twilio_number, for now we work with the messagingServiceSid
                'messagingServiceSid' => $msid,
                'body' => 'THIS IS A TEST MESSAGE', // ---- Here you can specify the text of the message you want to send
                'sendAt' => $datum[$x],
                'scheduleType' => 'fixed'
                //'statusCallback' => 'https://webhook.site/xxxxx' Callback function not yet implemented TBD
                )
        );

}

// ------ EOF schedule_send_sms.php
?>
