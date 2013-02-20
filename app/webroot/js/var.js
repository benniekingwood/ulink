/**
 * This file will setup the javascript related constants
 * for the application.  It will be based on the 
 * environment in which the application is running.
 */
var hostname ="";
var URL_IMAGES = "";
var URL_IMAGES_S3 = "";
var URL_DEFAULT_USER_IMAGE = "";

if (document.location.hostname == "localhost") {
	hostname="http://localhost:8888/";
 	URL_IMAGES = "http://localhost:8888/img/";
 	URL_IMAGES_S3 = "http://localhost:8888/img/"
 	URL_DEFAULT_USER_IMAGE = "http://localhost:8888/img/defaults/default_user.jpg";
} else {
	hostname="http://www.theulink.com/";
	URL_IMAGES = "http://www.theulink.com/img/";
	URL_IMAGES_S3 = "http://www.theulink.com/img/"
	URL_DEFAULT_USER_IMAGE = "http://www.theulink.com/img/defaults/default_user.jpg";
}