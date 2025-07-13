<?php
session_start();
require_once('../Models/DeliveryUsersDataSet.php');
require_once('../Models/DeliveryUserTypesDataSet.php');
require_once('../Models/AuthenticationFunctions.php');


$DeliveryUsersDataSet = new DeliveryUsersDataSet();
$DeliveryUserTypesDataSet = new DeliveryUserTypesDataSet();


//If user has already logged in before
if(isset($_SESSION['user']))
{
    $userTypeId = $_SESSION['user']['usertype'];
    $userType = $DeliveryUserTypesDataSet->fetchById($userTypeId)->getUserTypeName();
    if($userType == "Manager")
    {
        header("Location: userRecords.php");
        exit();
    }
    else
    {
        header("Location: delivererView.php");
        exit();
    }
}


//Normal login screen if user hasn't been logged in before
$view = new stdClass();
$view->pageTitle = 'ParcelBuddy - Login';

require_once('../Views/head.phtml');

if(isset($_POST['login']))
{


    $User = $DeliveryUsersDataSet->fetchByUsername($_POST['username']);
    if(isset($User))
    {
        if(checkPassword($_POST['password'], $User))
            {
                login($User);

                if($User->isManager())
                {
                    header("Location: userRecords.php");
                }
                else
                {
                    header("Location: delivererView.php");
                }

            }
        else
        {
            $view->errors[] = "Incorrect password!";
        }
    }
    else
    {
        $view->errors[] = "Username does not exist! Please check that you've entered the correct username!";
    }
}

require_once('../Views/login.phtml');




