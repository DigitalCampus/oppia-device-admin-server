<?php

require 'vendor/autoload.php';

use Coreproc\Gcm\GcmClient;
use Coreproc\Gcm\Classes\Message;

$gcmClient = new GcmClient('AIzaSyD5U4wzGoXPLEF1A2TTMH83GmaW3GBuyQs');

$registerID = $_POST['sender_id'];
$action = $_POST['action'];
$messageData = ['type' => 'admin', 'action' => $action];
if ($action == "password_lock"){
	$password = $_POST['password'];
	$messageData['password'] = $password;
}
$message = new Message($gcmClient);
$message->addRegistrationId($registerID);
$message->setData($messageData);

try {

    $response = $message->send();
    // The send() method returns a Response object
    print_r($response);

} catch (Exception $exception) {
    echo 'uh-oh: ' . $exception->getMessage();

}