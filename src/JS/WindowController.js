class WindowController {
    constructor() {
        this.XOffset = 0;
        this.YOffset = 0;
    }

    saveScrollPosition = () => {
        this.XOffset = window.scrollX;
        this.YOffset = window.scrollY;
    }

    scrollToSavedPosition = () => {
        window.scrollTo(this.XOffset, this.YOffset);
    }


}