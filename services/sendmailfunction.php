<?php
if (isset($_POST['submit'])) {
    function sendEmail($recipient, $subject, $body)
    {
        $api_endpoint = 'https://api.elasticemail.com/v2/email/send';
        $api_key = 'C7DAAD7E07A93059D2DA0EE30105232E1AA4551253BD4F7862D22CB7B794329D6F9A42F0E052F71F8223B4ECBAB13BBD';
        $email_data = array(
            'apikey' => $api_key,
            'to' => $recipient,
            'from' => 'bibekmagar746@gmail.com',
            'subject' => $subject,
            'body' => $body
        );

        // Send email using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($email_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            return 'cURL error: ' . curl_error($ch);
        } else {
            // Decode the JSON response
            $result = json_decode($response, true);

            // Check if the email was sent successfully
            if ($result['success']) {
                return 'Email sent successfully';
            } else {
                return 'Failed to send email. Error: ' . $result['error'];
            }
        }
        curl_close($ch);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>