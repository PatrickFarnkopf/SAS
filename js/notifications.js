/* =======================================================================

JS-File für den SAS Notification Center und das Popup selbst

Licensed under The Apache License
- Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
- https://github.com/pataga/SAS
- Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt
- Author: Gabriel Wanzek
========================================================================== */

var win=null;
onerror = stopError;

function stopError(){
	return true;
}

function poppy(){
	settings="width=500,height=630,top=20,left=20,scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes,dependent=no";
	win=window.open("?p=home&s=notification","SASNotifications",settings);
	win.focus();
}