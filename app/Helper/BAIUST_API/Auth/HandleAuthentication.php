<?php

namespace App\Helper\BAIUST_API\Auth;

class HandleAuthentication
{
 public static function perform_auth()
 {
  try {
   // API URL
   $url = "https://api.baiust.edu.bd/api/v.1/login";

   // Create a new cURL resource
   $ch = curl_init($url);

   // Setup request to send json via POST
   $data = array(
    "email" => "api@baiust.edu.bd",
    "password" => "BictAPIDaemon@2022"
   );
   $payload = json_encode($data);
   // return $payload;

   // Attach encoded JSON string to the POST fields
   curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

   // Set the content type to application/json
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));

   // Return response instead of outputting
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Execute the POST request
   $response = curl_exec($ch);

   // Close cURL resource
   curl_close($ch);
   $cookie_token = json_decode($response, true);
   $cookie = cookie('jwt', $cookie_token['token'], 60 * 24);
   return $cookie;
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}
