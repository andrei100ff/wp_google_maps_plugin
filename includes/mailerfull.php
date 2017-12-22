<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $fname = strip_tags(trim($_POST["first_name"]));
        $lname = strip_tags(trim($_POST["last_name"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $license = strip_tags(trim($_POST["license"]));
        $practice_name = strip_tags(trim($_POST["practice_name"]));
        $phone = strip_tags(trim($_POST["phone"]));
        $address = strip_tags(trim($_POST["address"]));
        $city = strip_tags(trim($_POST["city"]));
        $zip = strip_tags(trim($_POST["zip"]));
        $state = strip_tags(trim($_POST["state"]));
        $comment='';
        $comment = strip_tags(trim($_POST["comment"]));
        $lat = strip_tags(trim($_POST["lat"]));
        $lng = strip_tags(trim($_POST["lng"]));



        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "andrei@toronto-web-design.ca";

        // Set the email subject.
        $subject = "New contact from $fname $lname";

        // Build the email content.
        $email_content = "Name: $fname $lname\n";
        $email_content .= "Email: $email\n";
        $email_content .= "license: $license\n";
        $email_content .= "practice_name: $practice_name\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "address: $address\n\n";
        $email_content .= "city: $city\n\n";
        $email_content .= "zip: $zip\n\n";
        $email_content .= "state: $state\n\n";
        $email_content .= "Message:\n$comment\n";


        // Build the email headers.
        $email_headers = "From: $fname $lname <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

        /*DB*/

        include('connection.php');

        $query="INSERT INTO `adzlab` (`id`, `name`,`practice`, `license`, `email`, `phone`, `address`, `city`, `state`, `zip`, `signup`,`comment`, `lat`, `lng`) VALUES (NULL, '$fname $lname','$practice_name', '$license', '$email', '$phone', '$address', '$city', '$state', '$zip', CURRENT_TIMESTAMP, '$comment', '$lat', '$lng');";

        if(mysqli_query($connection,$query)){
            echo 'New record';
        }else{
            echo 'Error: '.mysqli_error($connection);
        }





    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }


?>