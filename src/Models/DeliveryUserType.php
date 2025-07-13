<?php


class DeliveryUserType implements JsonSerializable
{
    protected $id, $userTypeName;


    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->userTypeName = $dbRow['usertypename'];
    }

    //returns the serialized representation of the object (json object) so that it can be used in javascript
    public function jsonSerialize() : array
    {
        return ['id' => $this->id, 'userTypeName' => $this->userTypeName];
    }

    public function  getID()
    {
        return $this->id;
    }

    public function getUserTypeName()
    {
        return $this->userTypeName;
    }
}