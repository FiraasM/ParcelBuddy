<?php

require_once ('Database.php');
require_once ('DeliveryPoint.php');

//SELECT * FROM delivery_users LIMIT 10 offset 0;
class DeliveryPointsDataSet
{
    protected $dbHandle, $dbInstance;


    public function __construct() {
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }





    public function getRecordCount() {
        $sqlQuery = 'SELECT COUNT(*) AS numberOfRecords FROM delivery_point;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        $result = $statement->fetch();
        return $result['numberOfRecords'];
    }

    public function fetchDeliveryPoints($pageNumber) {
        $offset = ($pageNumber - 1) * 15;

        //15 records per page
        $sqlQuery = 'SELECT * FROM delivery_point LIMIT 15 offset ?;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $offset, PDO::PARAM_INT);


        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }



    public function fetchDelivererDeliveries($id, $pageNumber) {
        $offset = ($pageNumber - 1) * 15;

        $sqlQuery = 'SELECT * FROM delivery_point
        WHERE delivery_point.deliverer = ?
        LIMIT 15 offset ?;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $id);
        $statement->bindParam(2, $offset, PDO::PARAM_INT);

        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }



    public function getDelivererDeliveriesRecordCount($id) {
        $sqlQuery = 'SELECT COUNT(*) AS numberOfRecords 
                     FROM delivery_point
                     WHERE delivery_point.deliverer = ?;';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement
        $statement->bindParam(1, $id);
        $statement->execute(); // execute the PDO statement
        $result = $statement->fetch();
        return $result['numberOfRecords'];
    }

    public function insertDeliveryPoint($name, $address1, $address2, $postcode, $deliverer, $latitude, $longitude, $status)
    {

        $sqlQuery = 'INSERT INTO delivery_point(name, address_1, address_2, postcode, deliverer, lat, lng, status)
                    VALUES (?, ?, ?,?,?,?,?,?)';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->bindParam(1, $name);
        $statement->bindParam(2, $address1);
        $statement->bindParam(3, $address2);
        $statement->bindParam(4, $postcode);
        $statement->bindParam(5, $deliverer);
        $statement->bindParam(6, $latitude);
        $statement->bindParam(7, $longitude);
        $statement->bindParam(8, $status);

        $statement->execute(); // execute the PDO statement

    }

    public function deleteDeliveryPointById($id)
    {
        $sqlQuery = 'DELETE FROM delivery_point WHERE id = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->bindParam(1, $id);


        $statement->execute(); // execute the PDO statement
    }

    public function updateDeliveryPointById($id, $name, $address1, $address2, $postcode, $deliverer, $latitude, $longitude, $status)

    {
        $sqlQuery = 'UPDATE delivery_point SET
                          name = ?,
                          address_1 = ?,
                          address_2 = ?,
                          postcode = ?,
                          deliverer = ?,
                          lat = ?,
                          lng = ?,
                          status = ?
                          WHERE id = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->bindParam(1, $name);
        $statement->bindParam(2, $address1);
        $statement->bindParam(3, $address2);
        $statement->bindParam(4, $postcode);
        $statement->bindParam(5, $deliverer);
        $statement->bindParam(6, $latitude);
        $statement->bindParam(7, $longitude);
        $statement->bindParam(8, $status);
        $statement->bindParam(9, $id);



        $statement->execute(); // execute the PDO statement
    }

    public function updateDeliveryStatusById($id, $status)
    {
        $sqlQuery = 'UPDATE delivery_point SET
                          status = ?
                          WHERE id = ?';

        $statement = $this->dbHandle->prepare($sqlQuery); // prepare a PDO statement

        $statement->bindParam(1, $status);
        $statement->bindParam(2, $id);

        $statement->execute(); // execute the PDO statement
    }


}