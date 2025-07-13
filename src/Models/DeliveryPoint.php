<?php
require_once('../Models/DeliveryUsersDataSet.php');
require_once('../Models/DeliveryStatusesDataSet.php');
class DeliveryPoint implements JsonSerializable
{
    protected $id, $name, $address_1, $address_2, $postcode, $deliverer, $latitude, $longitude, $status, $photo;


    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->name = $dbRow['name'];
        $this->address_1 = $dbRow['address_1'];
        $this->address_2 = $dbRow['address_2'];
        $this->postcode = $dbRow['postcode'];
        $this->deliverer = $dbRow['deliverer'];
        $this->latitude = $dbRow['lat'];
        $this->longitude = $dbRow['lng'];
        $this->status = $dbRow['status'];
        $this->photo = $dbRow['del_photo'];
    }

    //returns the serialized representation of the object (json object) so that it can be used in javascript
    //objects like 'deliverer' will be jsonSerialized too so that it can be accessed by dot notation (e.g deliverer.username)
    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'name' => $this->name,
            'address_1' => $this->address_1,  'address_2' => $this->address_2,
            'postcode' => $this->postcode, 'deliverer' => $this->getDeliverer()->jsonSerialize(),
            'latitude' => $this->latitude, 'longitude' => $this->longitude,
            'status' => $this->getStatus()->jsonSerialize(), 'photo' => $this->photo];
    }

    //returns the id of the delivery point
    public function  getID()
    {
        return $this->id;
    }

    //returns the recipient of the delivery point
    public function getName()
    {
        return $this->name;
    }

    //returns the 'address1' of the recipient
    public function getAddress1()
    {
        return $this->address_1;
    }

    //return the 'address2' of the recipient
    public function getAddress2()
    {
        return $this->address_2;
    }

    //return the postcode of the recipient
    public function getPostcode()
    {
        return $this->postcode;
    }

    //return the user to deliver the delivery
    public function getDeliverer()
    {

        if(isset($this->deliverer))
        {
            $deliveryUsersDataset = new DeliveryUsersDataSet();

            return $deliveryUsersDataset->fetchById($this->deliverer);
        }
        return null;
    }

    //returns the latitude of where the delivery should be delivered to
    public function getLatitude()
    {
        return $this->latitude;
    }

    //returns the longitude of where the delivery should be delivered to
    public function getLongitude()
    {
        return $this->longitude;
    }
    //returns the status of the delivery
    public function getStatus()
    {
        $deliveryStatusesDataSet = new DeliveryStatusesDataSet();
        return $deliveryStatusesDataSet->fetchById($this->status);
    }
    public function getPhoto()
    {
        return $this->photo;
    }

}