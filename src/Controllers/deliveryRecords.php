<?php
session_start();
require_once('../Models/DeliveryUsersDataSet.php');
require_once('../Models/DeliveryUserTypesDataSet.php');
require_once ('../Models/DeliveryPointsDataSet.php');

require_once ('../Models/DeliveryUser.php');
require_once('../Models/AuthenticationFunctions.php');
require_once ('../Models/Validator.php');


if(isset($_POST['logout']))
{
    logout();
}
if(!isset($_SESSION['user']))
{
    header("Location: index.php");
    exit();
}


$deliveryPointsDataSet = new DeliveryPointsDataSet();

generateToken();

$view = new stdClass();

if(isset($_POST['viewUsers']))
{
    header('Location: userRecords.php');
    exit();
}

if(isset($_POST['addDelivery']))
{
    $recipient = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $postcode = $_POST['postcode'];
    $deliverer = $_POST['deliverer'];
    $status = $_POST['deliveryStatus'];

    if(!isset($view->errors))
    {
        $deliveryPointsDataSet = new DeliveryPointsDataSet();
        $deliveryPointsDataSet->insertDeliveryPoint($recipient, $address1, $address2, $postcode, $deliverer, $latitude, $longitude, $status);
        $view->successes[] = "New delivery has been added!";

    }


}

if(isset($_POST['deleteDelivery']))
{
    $id = $_POST['deleteDelivery'];
    $deliveryPointsDataSet = new DeliveryPointsDataSet();
    $deliveryPointsDataSet->deleteDeliveryPointById($id);
    $view->successes[] = "The selected delivery has been deleted!";


}


if(isset($_POST['editDelivery'])) {
    $deliveryId = $_POST['editDelivery'];
    $recipient = $_POST['name'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $postcode = $_POST['postcode'];
    $deliverer = $_POST['deliverer'];
    $status = $_POST['deliveryStatus'];

    if(!isset($view->errors))
    {
        $deliveryPointsDataSet = new DeliveryPointsDataSet();
        $deliveryPointsDataSet->updateDeliveryPointById($deliveryId, $recipient, $address1, $address2, $postcode, $deliverer, $latitude, $longitude, $status);
        $view->successes[] = "The selected user's details has been updated!";

    }

}

$view->pageNumber = 1;

if(isset($_GET['pageNumber']))
{
    $view->pageNumber = $_GET['pageNumber'];
}

$deliveriesDataSet = new DeliveryPointsDataSet();
$view->deliveries = $deliveriesDataSet->fetchDeliveryPoints($view->pageNumber);
$view->totalRecords = $deliveriesDataSet->getRecordCount();




$deliveryUsersDataSet = new DeliveryUsersDataSet();
$view->deliverers = $deliveryUsersDataSet->fetchAllDeliverers();

$deliveryStatusesDataSet = new DeliveryStatusesDataSet();
$view->deliveryStatuses = $deliveryStatusesDataSet->fetchAllDeliveryStatuses();




$view->pageTitle = 'ParcelBuddy - Delivery Records';

require_once('../Views/head.phtml');
require_once('../Views/managerNavBar.phtml');
require_once('../Views/deliveryRecords.phtml');
require_once ('../Views/footer.phtml');





