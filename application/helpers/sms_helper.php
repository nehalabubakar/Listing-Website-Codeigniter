<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('send_sms')) {
    function send_sms($message, $phone)
    {
        $sms_fields = array(
            'sender_id' =>  'TXTIND',               // This is a sender ID which shouldn't be changed
            'message'   =>  $message,               // This is a message which would be passed from a function
            'language'  =>  'english',              // Language of the message
            'route'     =>  'v3',                   // Route is provided by the API and shouldn't be changed
            'numbers'   =>  $phone,                 // Phone Number a message to be sent on
            'flash'     =>  0,                      // Flash is a pop message which woun't be shown in the messages

        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($sms_fields),
            CURLOPT_HTTPHEADER => array(
                // authorization is your API provided by Fast2SMS
                "authorization: 0TqLcG3wK7k9izhpglVbsQCu8jEyAfY4DFSo5WIPmRZ62xdeON02cSq9h7dznvH1Us5KmIkytTlDWZG4",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }
}
