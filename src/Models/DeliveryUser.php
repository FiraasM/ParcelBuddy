<?php
require_once('../Models/DeliveryUserTypesDataSet.php');

class DeliveryUser implements JsonSerializable
{
    protected $id, $username, $password, $userType;


    public function __construct($dbRow)
    {
        $this->id = $dbRow['userid'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
        $this->userType = $dbRow['usertype'];
    }

    //returns the serialized representation of the object (json object) so that it can be used in javascript
    //objects like 'userType' will be jsonSerialized too so that it can be accessed by dot notation (e.g userType.id)
    public function jsonSerialize() : array
    {

        return ['id' => $this->id, 'username' => $this->username, 'userType' => $this->getUserType()->jsonSerialize()];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserType()
    {
        $deliveryUserTypesDataSet = new DeliveryUserTypesDataSet();

        return $deliveryUserTypesDataSet->fetchById($this->userType);

    }

    public function isManager()
    {
        return $this->getUserType()->getUserTypeName() == "Manager";
    }



}