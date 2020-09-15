<?php
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://173.212.215.12/app/smsapi/index.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=25BEBA1A42769C&campaign=4417&routeid=100815&type=text&contacts=9229594776&senderid=STDADA&msg=test message");
    $response = curl_exec($ch);
    curl_close($ch);
?>