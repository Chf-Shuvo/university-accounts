<?php

namespace App\Helper\BAIUST_API\StudentRelated;

use App\Helper\BAIUST_API\Auth\HandleAuthentication;

class Information
{
 public static function all_student()
 {
  try {
   $cookie = HandleAuthentication::perform_auth();
   // API URL
   $url = "https://api.baiust.edu.bd/api/v.1/student/all-students";

   // Create a new cURL resource
   $ch = curl_init($url);

   // Set the content type to application/json
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'X-Requested-With:XMLHttpRequest', 'Cookie:' . $cookie));

   // Return response instead of outputting
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   // Execute the POST request
   $response = curl_exec($ch);

   // Close cURL resource
   curl_close($ch);
   return json_decode($response, true);
  } catch (\Throwable $th) {
   return $th->getMessage();
  }
 }
}
