
//This class is used to display records in a view
//Also has ability to limit number of records displayed in a view to optimise memory usage

class RecordViewController{
    constructor(recordDisplayLimit, generateRecordDisplayFunction){
        //How many batches of record can be displayed at once (a batch contains 15 individual records for this project)
        //Limit is placed so that client's experience will be smooth
        this.recordDisplayLimit = recordDisplayLimit;
        //How the record is displayed will be determined by this callback function specified by the developer
        this.generateRecordDisplay = generateRecordDisplayFunction;
        this.currentPageNumber = 1;
        this.frontPageNumber = 1;

    }


    //add records at the end of the view
    appendRecord = (jsonData) =>{
        this.incrementPageNumber();
        document.getElementById("recordView").innerHTML += recordViewController.generateRecordDisplay(this.currentPageNumber, jsonData);
        this.updateRecordView()
    }

    //add records at the front of the view
    prependRecord = (jsonData) =>{
        this.decrementPageNumber();
        document.getElementById("recordView").innerHTML = recordViewController.generateRecordDisplay(this.frontPageNumber, jsonData) + document.getElementById("recordView").innerHTML;
        this.updateRecordView()
    }


//updateRecordView ensures the record view comply with the limit set by the field 'recordDisplayLimit'
    //The function is called whenever a record display has been added to the view
    updateRecordView = () => {
        //removes any record display past the page number (Happens when 'load previous' button is clicked)
        let recordDisplayPastPageNumber = document.getElementById("recordDisplay" + parseInt(this.currentPageNumber + 1));
        if(recordDisplayPastPageNumber !== null) {
            recordDisplayPastPageNumber.outerHTML = '';
        }

        //removes any record display before the front page number (Sometime happens when 'load more' button is clicked)
        let recordDisplayBeforeFrontPageNumber = document.getElementById("recordDisplay" + parseInt(this.frontPageNumber - 1));
        if(recordDisplayBeforeFrontPageNumber !== null) {
            recordDisplayBeforeFrontPageNumber.outerHTML = '';
            this.showLoadPreviousButton();
        }

        //if all previous record has been displayed
        if(this.frontPageNumber === 1) {
            this.hideLoadPreviousButton();
        }else{
            this.showLoadPreviousButton();
        }


        this.showLoadMoreButton();
    }


    getLoadMoreButton = function()
    {
        return document.getElementById("loadMore");
    }

    getLoadPreviousButton = function(){
        return document.getElementById("loadPrevious");
    }



    hideLoadPreviousButton = function()
    {
        document.getElementById("loadPreviousButton").innerHTML = '';
    }


    hideLoadMoreButton = function()
    {
        document.getElementById("loadMoreButton").innerHTML = 'No more records to display!';
    }

    incrementPageNumber = function (){
        this.currentPageNumber++;
        this.frontPageNumber = this.currentPageNumber - (this.recordDisplayLimit - 1);
        if(this.frontPageNumber <= 0){
            this.frontPageNumber = 1;
        }
    }

    decrementPageNumber = function (){
        this.currentPageNumber--;
        this.frontPageNumber = this.currentPageNumber - (this.recordDisplayLimit - 1);
        if(this.frontPageNumber <= 0){
            this.frontPageNumber = 1;
        }
    }

    getCurrentPageNumber = () => this.currentPageNumber;

    getFrontPageNumber = () => this.frontPageNumber;


    //Replaces the button with a loading gif (lets the user know the new records are loading)
    //Removing event listeners prevents user from spamming requests
    showLoadingForLoadMoreButton = function(){
        removeAllEventListeners(document.getElementById("loadMoreButton"));
        document.getElementById("loadMoreButton").innerHTML = '<img src="../Assets/loading.gif" alt="loading next page">';
    }

    showLoadingForPreviousButton = function(){
        removeAllEventListeners(document.getElementById("loadPreviousButton"));
        document.getElementById("loadPreviousButton").innerHTML = '<img src="../Assets/loading.gif" alt="loading previous page">';
    }

    //Event is registered again to allow user to request for more data once it is shown
    showLoadPreviousButton = function(displayNumber){
        document.getElementById("loadPreviousButton").innerHTML = '<button class="btn btn-primary" id="loadPrevious" value="' + displayNumber+ '"> Load previous records</button>';
        document.getElementById("loadPreviousButton").addEventListener("click", loadPreviousRecordDisplay);
    }

    showLoadMoreButton = function(displayNumber)
    {
        document.getElementById("loadMoreButton").innerHTML = '<button class="btn btn-primary" id="loadMore" value="' + displayNumber + '"> Load more</button>';
        document.getElementById("loadMoreButton").addEventListener("click", loadNextRecordDisplay);
    }




}