
//Removes event listeners by replace the element with a clone (The event listeners aren't cloned)
function removeAllEventListeners(element) {
    const clonedElement = element.cloneNode(true);
    element.parentNode.replaceChild(clonedElement, element);
}