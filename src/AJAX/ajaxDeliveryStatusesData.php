<?php
//delivery's status (such as 'Out for delivery', 'shipped' etc.) are retrieved from here using AJAX
session_start();
require_once('../Models/DeliveryUsersDataSet.php');
require_once ('../Models/DeliveryUser.php');
require_once('../Models/DeliveryStatusesDataSet.php');
require_once ('../Models/DeliveryStatus.php');
require_once('../Models/AuthenticationFunctions.php');


//Checks if the token is valid and the user aren't requesting data too fast (prevents spamming) before passing the data to the client
if(isTokenValid() && checkRateLimit())
{
    $deliveryStatusesDataset  = new DeliveryStatusesDataSet();
    $deliveryStatusData = $deliveryStatusesDataset->fetchAllDeliveryStatuses();
    echo json_encode($deliveryStatusData);

}
else
{

    echo json_encode(["Error" => "Access denied!"]);

}
