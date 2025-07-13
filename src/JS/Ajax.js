
//Ajax allows you to make asynchronous HTTP request
//It also allows you to make changes to the pages without refreshing it
class Ajax{
    constructor() {
        this.xhr = new XMLHttpRequest();
    }


    //Allows you to make an AJAX request to a specified url
    sendRequest(method, url, data, successCallBack, errorCallBack){
        //Opens a connection to the specified url with the given method
        this.xhr.open(method, url);

        this.xhr.onreadystatechange = ()=> {
            var DONE = 4;
            var OK = 200;

            if(this.xhr.readyState === DONE) {

                if(this.xhr.status === OK) {
                    //If a response is received
                    successCallBack(this.xhr.responseText);
                }
                else {
                    //If there is no response received
                    errorCallBack();
                }
            }

        }


        this.xhr.send(data);

    }

}

