/* getElementBBox(element)
     This function returns an object having .x and .y properties which are the coordinates
     of the given element, relative to the page. */
function getElementBBox(element) {
	/* This function will return an Object with x and y properties */
	var useWindow=false;
	var boundingbox=new Object();
	var x=0,y=0,w=0,h=0;
	/* Browser capability sniffing */
	var use_gebi=false, use_css=false, use_layers=false;
	if (document.getElementById) { use_gebi=true; }
	else if (document.all) { use_css=true; }
	else if (document.layers) { use_layers=true; }
	/* Logic to find position */
 	if (use_gebi && document.all) {
		x=ElementPosition_getPageOffsetLeft(element);
		y=ElementPosition_getPageOffsetTop(element);
    w=element.offsetWidth;
    h=element.offsetHeight;
	}
	else if (use_gebi) {
		x=ElementPosition_getPageOffsetLeft(element);
		y=ElementPosition_getPageOffsetTop(element);
    w=element.offsetWidth;
    h=element.offsetHeight;
  }
 	else if (use_css) {
		x=ElementPosition_getPageOffsetLeft(element);
		y=ElementPosition_getPageOffsetTop(element);
    w=element.style.width;
    h=element.style.height;
  }
	else if (use_layers) {
		x=element.x;
		y=element.y;
    w=element.w;
    h=element.h;
	}
	else {
		boundingbox.x=0;
    boundingbox.y=0;
    boundingbox.w=0;
    boundingbox.h=0;
    return boundingbox;
	}
	boundingbox.x=x;
	boundingbox.y=y;
	boundingbox.w=w;
	boundingbox.h=h;
	return boundingbox;
}

/* getElementWindowBBox(element)
     This function returns an object having .x and .y properties which are the coordinates
     of the given element, relative to the window */
function getElementWindowBBox(element) {
	var coordinates=getElementPosition(element);
	var x=0,y=0,w=0,h=0;
	if (document.getElementById) {
		if (isNaN(window.screenX)) {
			x=coordinates.x-document.body.scrollLeft+window.screenLeft;
			y=coordinates.y-document.body.scrollTop+window.screenTop;
		}
		else {
			x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;
			y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;
		}
    w=element.w;
    h=element.h;
	}
	else if (document.all) {
		x=coordinates.x-document.body.scrollLeft+window.screenLeft;
		y=coordinates.y-document.body.scrollTop+window.screenTop;
    w=element.offsetWidth;
    h=element.offsetHeight;
	}
	else if (document.layers) {
		x=coordinates.x+window.screenX+(window.outerWidth-window.innerWidth)-window.pageXOffset;
		y=coordinates.y+window.screenY+(window.outerHeight-24-window.innerHeight)-window.pageYOffset;
    w=element.w;
    h=element.h;
	}
	coordinates.x=x;
	coordinates.y=y;
  coordinates.w=w;
  coordinates.h=h;
	return coordinates;
}

/* Functions for IE to get position of an object */
function ElementPosition_getPageOffsetLeft(el) {
	var ol=el.offsetLeft;
	while ((el=el.offsetParent) != null) { ol += el.offsetLeft; }
	return ol;
}

function ElementPosition_getWindowOffsetLeft (el) {
	return ElementPosition_getPageOffsetLeft(el)-document.body.scrollLeft;
}	

function ElementPosition_getPageOffsetTop (el) {
	var ot=el.offsetTop;
	while((el=el.offsetParent) != null) { ot += el.offsetTop; }
	return ot;
}

function ElementPosition_getWindowOffsetTop (el) {
	return ElementPosition_getPageOffsetTop(el)-document.body.scrollTop;
}
