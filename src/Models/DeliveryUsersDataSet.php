<?php

require_once ('Database.php');
require_once ('DeliveryUser.php');

class DeliveryUsersDataSet
{
    protected $dbHandle, $dbInstance;


    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    public function fetchAllDeliveryUsers() {
        $sqlQuery = 'SELECT * FROM delivery_users';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUser($row);
        }
        return $dataSet;
    }

    public function fetchDeliveryUsers($pageNumber) {
        $dataSet = [];

        if($pageNumber < 0)
        {
            return $dataSet;
        }

        $offset = ($pageNumber - 1) * 15;

        //15 records per page
        $sqlQuery = 'SELECT * FROM delivery_users LIMIT 15 offset ?;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $offset, PDO::PARAM_INT);


        $statement->execute(); // execute the PDO statement


        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUser($row);
        }
        return $dataSet;
    }


    public function getRecordCount() {
        $sqlQuery = 'SELECT COUNT(*) AS numberOfRecords FROM delivery_users;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $result = $statement->fetch();
        return $result['numberOfRecords'];
    }

    public function fetchById($id)
    {
        $sqlQuery = 'SELECT * FROM delivery_users WHERE userid = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $id);
        $statement->execute(); // execute the PDO statement

        $row = $statement->fetch();
        if(isset($row)) {
            return new DeliveryUser($row);
        }
        else
        {
            return null;
        }
    }

    public function fetchByUsername($username)
    {
        $sqlQuery = 'SELECT * FROM delivery_users WHERE username = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $username);
        $statement->execute(); // execute the PDO statement

        $row = $statement->fetch();
        if(!$row) {
            return null;
        }

        return new DeliveryUser($row);

    }

    public function fetchAllDeliverers()
    {
        $sqlQuery = 'SELECT * FROM delivery_users
                        INNER JOIN delivery_usertype ON delivery_users.usertype = delivery_usertype.id
                        WHERE delivery_usertype.id= 2';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUser($row);
        }
        return $dataSet;

    }

    public function containsUsername($username)
    {
        $result = $this->fetchByUsername($username);
        if(isset($result))
        {
            return true;
        }
        return false;

    }

    public function insertDeliveryUser($username, $password, $userType)
    {
        $password=password_hash($password, PASSWORD_DEFAULT);

        $sqlQuery = 'INSERT INTO delivery_users(username, password, usertype)
                    VALUES (?, ?, ?)';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->bindParam(1, $username);
        $statement->bindParam(2, $password);
        $statement->bindParam(3, $userType);

        $statement->execute(); // execute the PDO statement

    }

    public function deleteDeliveryUserById($id)
    {
        $sqlQuery = 'DELETE FROM delivery_users WHERE userid = ?';
        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $id);
        $statement->execute(); // execute the PDO statement
    }

    public function updateDeliveryUserById($id, $username, $password, $userType)

    {
        $sqlQuery = 'UPDATE delivery_users SET
                          username = ?,
                          password = ?,
                          usertype = ?
                          WHERE userid = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $username);
        $statement->bindParam(2, $password);
        $statement->bindParam(3, $userType);
        $statement->bindParam(4, $id);



        $statement->execute(); // execute the PDO statement
    }




}