
//Uses animation from clientserver/CSS/animation.css
function animateFadeIn(elementID)
{
    document.getElementById(elementID).classList.add('fadeIn');
    setTimeout(removeClassFromID, 750, elementID, 'fadeIn');
}

function animateMoveRightToLeft(elementID)
{
    document.getElementById(elementID).classList.add('moveRightToLeft');
    setTimeout(removeClassFromID, 750, elementID, 'moveRightToLeft');
}


function fadeInFromRightToLeft(elementID)
{
    document.getElementById(elementID).classList.add('fadeInFromRightToLeft');
    setTimeout(removeClassFromID, 750, elementID, 'fadeInFromRightToLeft');
}


//Anytime an animation is completed (takes 0.5 seconds to complete)
//The class that causes the element to animate, will be removed
//This is so that the animation doesn't cause any bugs to happen (it broke bootstrap modal fade-in animation)
//It also allows the elements to be animated again
function removeClassFromID(elementID, animationClass) {
    document.getElementById(elementID).classList.remove(animationClass);
}


