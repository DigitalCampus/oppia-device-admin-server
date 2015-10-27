<?php

require_once('db/oppia_db.php');
$fields = array('device_id', 'model_name', 'sender_id', 'username');
$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    echo 'Field '.$fieldname.' missing!<br />'; //Display error with field
    $error = true;
  }
}
if ($error){
	http_response_code(400);
	die();
}

$deviceId = $_POST['device_id'];
$modelName = $_POST['model_name'];
$senderId = $_POST['sender_id'];
$username = $_POST['username'];
$registered = date("F Y");

$query = <<<EOD
  INSERT OR REPLACE INTO  devices(device_id, model_name, sender_id, username, registered) VALUES
  ( '$deviceId', '$modelName', '$senderId', '$username', '$registered' );
EOD;
$success = $db->exec($query);
$db = NULL;
if (!$success){
	http_response_code(400);
	die("Unable to add device");
}

?>