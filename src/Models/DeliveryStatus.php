<?php


class DeliveryStatus implements JsonSerializable
{
    protected $id, $statusCode, $statusText;


    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->statusCode = $dbRow['status_code'];
        $this->statusText = $dbRow['status_text'];
    }

    //returns the serialized representation of the object (json object) so that it can be used in javascript
    public function jsonSerialize()
    {
        return ['id' => $this->id, 'statusCode' => $this->statusCode, 'statusText' => $this->statusText];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getStatusText()
    {
        return $this->statusText;
    }


}