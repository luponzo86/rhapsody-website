<?PHP
# run this script from a browser to check if emails are sent correctly

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

// change here
$sender = 'dcb@pitt.edu';
$recipient = 'lponzoni@pitt.edu';

$subject = "php mail test";
$message = "php test message";
$headers = 'From:' . $sender;

if (mail($recipient, $subject, $message, $headers))
{
    echo "Message accepted";
}
else
{
  echo "Error: Message not accepted <br><br>";
  print_r(apache_request_headers());
}
?>
