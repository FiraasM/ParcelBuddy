<?php

require_once ('Database.php');
require_once ('DeliveryUserType.php');

class DeliveryUserTypesDataSet
{
    protected $dbHandle, $dbInstance;


    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    public function fetchAllDeliveryUserTypes() {
        $sqlQuery = 'SELECT * FROM delivery_usertype';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUserType($row);
        }
        return $dataSet;
    }

    public function getRecordCount() {
        $sqlQuery = 'SELECT COUNT(*) AS numberOfRecords FROM delivery_usertype;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $result = $statement->fetch();
        return $result['numberOfRecords'];
    }

    public function fetchById($id)
    {
        $sqlQuery = "SELECT * FROM delivery_usertype WHERE id = ?";

        $statement = $this->dbHandle->prepare($sqlQuery);

        $statement->bindParam(1,$id);
        $statement->execute();

        $row = $statement->fetch();
        return new DeliveryUserType($row);
    }
}