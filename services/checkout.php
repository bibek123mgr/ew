<?php
include('../connection.php');

if (isset($_POST['submit'])) {
   if (empty($_POST['email'])) {
      echo 'Please enter the email address';
      exit();
   }
   $email = $_POST['email'];
   $sql = "SELECT * FROM users WHERE email='$email'";
   $query = mysqli_query($conn, $sql);
   if ($query && mysqli_num_rows($query) > 0) {
      $api_endpoint = 'https://api.elasticemail.com/v2/email/send';
      $api_key = 'C7DAAD7E07A93059D2DA0EE30105232E1AA4551253BD4F7862D22CB7B794329D6F9A42F0E052F71F8223B4ECBAB13BBD';

      // Email data
      $email_data = array(
         'apikey' => $api_key,
         'to' => $email,
         'from' => 'bibekmagar746@gmail.com',
         'subject' => 'Test Email',
         'body' => 'This is a test email sent using the Elastic Email API.'
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_endpoint);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($email_data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);

      if ($response === false) {
         echo 'cURL error: ' . curl_error($ch);
      } else {
         $result = json_decode($response, true);

         if ($result['success']) {
            echo 'Email sent successfully ';
         } else {
            echo 'Failed to send email. Error: ' . $result['error'];
         }
      }
      curl_close($ch);
   } else {
      echo "Unable to send mail";
   }
}
