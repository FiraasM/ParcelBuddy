<?php
//All the delivery points are retrieved from here using AJAX
session_start();
require_once('../Models/DeliveryPoint.php');
require_once ('../Models/DeliveryPointsDataSet.php');
require_once('../Models/AuthenticationFunctions.php');

//Ensures performance isn't compromised as records are split into 'pages' that you can load
$pageNumber = 1;
if(isset($_GET['pageNumber'])) {
    $pageNumber = $_GET['pageNumber'];
}

//Checks if the token is valid and the user aren't requesting data too fast (prevents spamming) before passing the data to the client
//Only manager can have access to this data
if(isTokenValid() && isSessionUserAManager() && checkRateLimit())
{
    $deliveryPointsDataSet = new DeliveryPointsDataSet();
    $deliveryPointsData = $deliveryPointsDataSet->fetchDeliveryPoints($pageNumber);
    echo json_encode($deliveryPointsData);


}
else
{

    echo json_encode(["Error" => "Access denied!"]);


}
