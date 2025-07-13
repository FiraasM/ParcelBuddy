<?php
session_start();
require_once('../Models/DeliveryUsersDataSet.php');
require_once ('../Models/DeliveryUser.php');
require_once('../Models/DeliveryUserTypesDataSet.php');
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

if(isset($_POST['viewDeliveries']))
{
    header('Location: deliveryRecords.php');
    exit();
}
$deliveryUsersDataSet = new DeliveryUsersDataSet();


generateToken();

$view = new stdClass();

if(isset($_POST['addUser']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];


    if(!Validator::stringLength($username, 25))
    {
        $view->errors[] = "Your username cannot be longer than 25 characters!";
    }


    if($deliveryUsersDataSet->containsUsername($username))
    {
        $view->errors[] = "The username entered has already been taken, please enter a different username!";
    }

    if(!isset($view->errors))
    {
        $deliveryUsersDataSet->insertDeliveryUser($username, $password, $userType);
        $view->successes[] = "New user has been added!";
    }

}

if(isset($_POST['deleteUser']))
{
    $id = $_POST['deleteUser'];
    $deliveryUsersDataSet = new DeliveryUsersDataSet();
    $deliveryUsersDataSet->deleteDeliveryUserById($id);
    $view->successes[] = "The selected user has been deleted!";


}

if(isset($_POST['editUser']))
{
    $userId = $_POST['editUser'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    //If the password field is left empty (The user doesn't want to change the password)
    if(empty($password))
    {
        $deliveryUsersDataSet = new DeliveryUsersDataSet();
        $password = $deliveryUsersDataSet->fetchById($userId)->getPassword();
    }

    if(!isset($view->errors))
    {
        $deliveryUsersDataSet = new DeliveryUsersDataSet();
        $deliveryUsersDataSet->updateDeliveryUserById($userId, $username, $password, $userType);
        $view->successes[] = "The selected user's details has been updated!";


    }


}


$view->pageNumber = 1;

if(isset($_GET['pageNumber']))
{
    $view->pageNumber = $_GET['pageNumber'];
}

$deliveryUsersDataSet = new DeliveryUsersDataSet();
$view->users = $deliveryUsersDataSet->fetchDeliveryUsers($view->pageNumber);
$view->totalRecords = $deliveryUsersDataSet->getRecordCount();


$view->pageTitle = 'ParcelBuddy - User Records';

require_once('../Views/head.phtml');
require_once('../Views/managerNavBar.phtml');
require_once('../Views/userRecords.phtml');
require_once ('../Views/footer.phtml');





