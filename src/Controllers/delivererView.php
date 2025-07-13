<?php
session_start();
require_once('../Models/DeliveryUsersDataSet.php');
require_once('../Models/DeliveryUserTypesDataSet.php');
require_once ('../Models/DeliveryPointsDataSet.php');

require_once ('../Models/DeliveryUser.php');
require_once('../Models/AuthenticationFunctions.php');
require_once ('../Models/Validator.php');
require_once('../Models/AuthenticationFunctions.php');


//if user pressed the logout button
if(isset($_POST['logout']))
{
    logout();
}

//If the user is not logged in
if(!isset($_SESSION['user']))
{
    header("Location: index.php");
    exit();
}

//Generate a token to be used in data transaction as a form of stronger authentication
generateToken();


$view = new stdClass();

//If the user want to update a delivery...
if(isset($_POST['updateDelivery']))
{
    $id = $_POST['updateDelivery'];
    $deliveryStatusId = $_POST['deliveryStatus'];
    $deliveriesDataSet = new DeliveryPointsDataSet();
    $deliveriesDataSet->updateDeliveryStatusById($id, $deliveryStatusId);

    $view->successes[] = "The selected user's details has been updated!";
}

$view->pageTitle = 'ParcelBuddy - Your Deliveries';

//Allows the user to view different pages of records (record are split into pages for performance gain)
$view->pageNumber = 1;

if(isset($_GET['pageNumber']))
{
    $view->pageNumber = $_GET['pageNumber'];
}

//Grabs the logged in user's ID to retrieve their deliveries to display in the view
$currentUser = $_SESSION['user']['id'];
$deliveriesDataSet = new DeliveryPointsDataSet();
$view->deliveries = $deliveriesDataSet->fetchDelivererDeliveries($currentUser, $view->pageNumber);
$view->totalRecords = $deliveriesDataSet->getDelivererDeliveriesRecordCount($currentUser);

//Grabs every single delivery status to display in the view
$deliveryStatusesDataSet = new DeliveryStatusesDataSet();
$view->deliveryStatuses = $deliveryStatusesDataSet->fetchAllDeliveryStatuses();

require_once('../Views/head.phtml');
require_once ('../Views/delivererNavBar.phtml');
require_once('../Views/delivererView.phtml');
require_once ('../Views/footer.phtml');





