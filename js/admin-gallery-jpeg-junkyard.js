//Use this file to inject custom javascript behaviour into the foogallery edit page
//For an example usage, check out wp-content/foogallery/extensions/default-templates/js/admin-gallery-default.js

(function (JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION, $, undefined) {

	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION.doSomething = function() {
		//do something when the gallery template is changed to jpeg-junkyard
	};

	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION.adminReady = function () {
		$('body').on('foogallery-gallery-template-changed-jpeg-junkyard', function() {
			JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION.doSomething();
		});
	};

}(window.JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION = window.JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION || {}, jQuery));

jQuery(function () {
	JPEG_JUNKYARD_TEMPLATE_FOOGALLERY_EXTENSION.adminReady();
});