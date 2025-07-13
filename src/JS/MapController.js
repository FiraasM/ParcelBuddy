
class MapController {
    constructor(elementId, defaultCenter, zoom, markerFormatFunction, recordDisplayLimit) {
        this.map = null;
        this.tileLayer = null;
        this.elementId = elementId; //The map is placed inside the element of the specified ID
        this.defaultCenter = defaultCenter; //this is used if client's location cannot be retrieved
        this.zoom = zoom;

        //A function that will determine how marker are created and displayed
        this.generateMarker = markerFormatFunction;


        //How many batches of record can be displayed at once (a batch contains 15 individual records for this project)
        //Limit is placed so that client's experience will be smooth
        this.recordDisplayLimit = recordDisplayLimit;
        this.currentPageNumber = 0;
        this.frontPageNumber = 1;
        this.markerMap = new Map();
    }


    //onLoadFunction - function passed by the developer that will be executed once the map loads
    initialise = (onLoadFunction) =>{
        this.onLoadFunction = onLoadFunction;
        //If geolocation is supported
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(this.getCurrentPositionSuccess, this.getCurrentPositionFail)
        }else
        {
            window.alert("ERROR! no geolocation data available")
        }


    }

    //Sets up the map based on the client's location
    getCurrentPositionSuccess = (position) =>
    {
        this.map = L.map(this.elementId).setView([position.coords.latitude, position.coords.longitude], this.zoom);

        this.tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map);

        this.tileLayer.on("load", this.onTileLoad)

    }

    //Sets up the map with default location
    getCurrentPositionFail = () =>
    {
        this.map = L.map(this.elementId).setView(this.defaultCenter, this.zoom);

        this.tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map);


        this.tileLayer.on("load", this.onTileLoad)

    }


    //Create markers based on the format given by the developer
    //Markers are stored by page number (so that markers can be removed once it's no longer in the record view to improve performance)
    appendMarkersFor = (jsonData) =>
    {
        this.incrementPageNumber();
        this.createMarkersFor(jsonData, this.currentPageNumber)
        this.updateMapView()

    }

    prependMarkersFor = (jsonData) =>
    {
        this.decrementPageNumber();
        this.createMarkersFor(jsonData, this.frontPageNumber)
        this.updateMapView();
    }

//Creates marker to display on the map and store it in a 'markerMap' to be able to delete the marker later
    //Stored in a 'hashmap' with the pageNumber as key and the array of markers as value
    createMarkersFor = (jsonData, pageNumber) =>
    {
        let markers = [];
        jsonData.forEach((data) => {markers.push(this.generateMarker(data))});
        this.markerMap.set(pageNumber, markers);
    }


    updateMapView = () => {
        //removes any markers past the page number (Happens when 'load previous' button is clicked)
        let markersPastCurrentPageNumber = this.currentPageNumber + 1;
        if(this.markerMap.has(markersPastCurrentPageNumber) === true) {
            this.removeMarkersFromMap(this.markerMap.get(markersPastCurrentPageNumber));
            this.markerMap.delete(markersPastCurrentPageNumber);
        }

        //removes any markers before the front page number (Sometimes happens when 'load more' button is clicked)
        let recordDisplayBeforeFrontPageNumber = this.frontPageNumber - 1;
        if(this.markerMap.has(recordDisplayBeforeFrontPageNumber) === true) {
            this.removeMarkersFromMap(this.markerMap.get(recordDisplayBeforeFrontPageNumber));
            this.markerMap.delete(recordDisplayBeforeFrontPageNumber);
        }



    }

    //An event listener that will be called once the map fully loads
    //onLoadFunction - function passed by the developer that will be executed once the map loads
    onTileLoad = () => {
        this.onLoadFunction()
        this.tileLayer.off("load", this.onTileLoad)
    }

    getMap = () =>{
        return this.map;
    }

    removeMarkersFromMap = (markers) =>{
        markers.forEach((marker) => {this.map.removeLayer(marker)});
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



}