<?php

//checks if the password entered, matches the hashed version of the password in the database
 function checkPassword($enteredPassword, $userData)
{
    $password = $userData->getPassword();
    if (password_verify($enteredPassword, $password)) {
        login($userData);
        return true;

    } else
    {
        return false;
    }
}

//Generate a token to be used in data transaction as a form of stronger authentication for AJAX
function generateToken()
{
    $token = substr(str_shuffle(MD5(microtime())), 0, 25);
    $_SESSION['token'] = $token;
    $_SESSION['tokenCreated'] = time();
}

//Checks if the session has lasted too long
//This ensures that unattended computer that hasn't been completely shut off still can't access the website and its data
function checkTokenLifetime(): bool
{
    if(!isset($_SESSION['tokenCreated'])) {return false;}
    $maximumLifetime = 60 * 5;
    $timeTokenCreated = $_SESSION['tokenCreated'];
    $tokenLifetime = time() - $timeTokenCreated;

    if ($tokenLifetime > $maximumLifetime) {return false;}
    else{return true;}
}


//Prevents the user from spamming requests
function checkRateLimit() : bool
{
    $timeToRefill = 30; //How long till the amount of request they can make refreshes (in seconds)
    $requestPerRefill = 50;

    //Checks if the client's number of request can be refilled
    if(!isset($_SESSION['requestRefilled']) || (time() - $_SESSION['requestRefilled']) > $timeToRefill)
    {
        $_SESSION['requestRefilled'] = time();
        $_SESSION['numOfRequests'] = $requestPerRefill;
    }

    //If they can still make requests
    if($_SESSION['numOfRequests'] > 0)
    {
        //decrement the amount of request they can make (This happens everytime a request is made)
        $_SESSION['numOfRequests']--;
        return true;
    }
    else
    {
        return false;
    }

}


//Checks if the logged in user is a manager
//This is used when a client tries to access data a normal user shouldn't access
function isSessionUserAManager() : bool
{
    if(isset($_SESSION['user']))
    {
        $userId = $_SESSION['user']['id'];
        $deliveryUserDataSet = new DeliveryUsersDataSet();
        $user = $deliveryUserDataSet->fetchById($userId);
        return $user->isManager();


    }
    return false;
}


//Checks the token to see if it's valid
function isTokenValid() : bool
{
    //If the token has existed for too long (session has expired)
    if(!checkTokenLifetime())
    {
        return false;
    }


    $token = "";
    //retrieves the token the user has to match with
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];
    }

    //Rejects the client if the client hasn't provided any token or if the token doesn't match the one stored in the server's session
    if(!isset($_GET['token']) || $_GET['token'] != $token) {
        return false;
    }

    return true;
}


 function login($userData)
{
    $_SESSION['user'] = [
            'id' => $userData->getId(),
            'username' => $userData->getUsername(),
            'userType' => $userData->getUserType()
        ];

}

function logout()
{
    session_destroy();
    header("location: login.php");
    exit();
}

