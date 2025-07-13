
<?php
//Delivery points that belongs to a certain deliverer are retrieved here (by their ID) using AJAX
session_start();
require_once('../Models/DeliveryPoint.php');
require_once ('../Models/DeliveryPointsDataSet.php');
require_once('../Models/AuthenticationFunctions.php');


//Ensures performance isn't compromised as records are split into 'pages' that you can load
$pageNumber = 1;
if(isset($_GET['pageNumber'])) {
    $pageNumber = $_GET['pageNumber'];
}

//Grabs the logged in user's ID to retrieve their deliveries
$currentUser = $_SESSION['user']['id'];

//Checks if the token is valid and the user aren't requesting data too fast (prevents spamming) before passing the data to the client
if(isTokenValid() &&  checkRateLimit())
{
    $deliveryPointsDataSet = new DeliveryPointsDataSet();
    $deliveryPointsData = $deliveryPointsDataSet->fetchDelivererDeliveries($currentUser,$pageNumber);
    echo json_encode($deliveryPointsData);


}
else
{

    echo json_encode(["Error" => "Access denied!"]);


}
