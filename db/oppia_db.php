<?php
$db = new PDO('sqlite:'.dirname(__FILE__).'/oppia_devices.sqlite') or die('Unable to open database');
$query = <<<EOD
  CREATE TABLE IF NOT EXISTS devices (
    device_id STRING PRIMARY KEY,
    model_name STRING,
    registered STRING,
    username STRING,
    sender_id STRING)
EOD;
$db->exec($query);
?>