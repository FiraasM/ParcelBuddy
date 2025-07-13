
//for fetching delivery statuses in javascript
class DeliveryStatuses {
    constructor(token){

        let ajax = new Ajax();
        ajax.sendRequest("GET", "../AJAX/ajaxDeliveryStatusesData.php?token=" + token, null,
            (responseText) =>{
                this.statuses = JSON.parse(responseText);
            },
            function errorCallBack(){
                console.log("RESPONSE ERROR!");
            })
    }


    //retrieves an array of statuses
    getStatuses = () => this.statuses;
}