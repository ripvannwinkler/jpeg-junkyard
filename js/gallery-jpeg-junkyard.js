var gallery = [].slice.call(document.querySelectorAll('.jj-gallery-item a'));
var container = document.querySelector('.jj-image-container');

function galleryItemClick(e) {
	e.stopPropagation();
	e.preventDefault();
	var url = e.currentTarget.href;
	setPreviewImage(url);
}

function setPreviewImage(url) {
	var bg = 'url(' + url + ')'
	container.style.backgroundImage = bg;
}

function getIndexByUrl() {
	var expr = /url\((.+)\)/gi
	var style = container.style.backgroundImage;
	var match = expr.exec(style);
	var url = match[1];

	url = url.replace(/["']/gi, '');
	for (var i = 0; i < gallery.length; i++) {
		var href = gallery[i].getAttribute('href');
		if (href.toLowerCase() === url.toLowerCase()) {
			return i;
		}
	}

	return -1;
}

function galleryPreviewNext() {
	var index = getIndexByUrl();
	var next = ++index > gallery.length - 1 ? 0 : index;
	setPreviewImage(gallery[next].href);
}

function galleryPreviewPrev() {
	var index = getIndexByUrl();
	var prev = --index < 0 ? gallery.length - 1 : index;
	setPreviewImage(gallery[prev].href);
}

function galleryPreviewClick(e) {
	if (e.offsetX < e.target.clientWidth / 2) {
		galleryPreviewPrev(e);
	} else if (e.offsetX > e.target.clientWidth / 2) {
		galleryPreviewNext(e);
	}
}

function initGalleryItems() {
	for (var i = 0; i < gallery.length; i++) {
		var item = gallery[i];
		item.addEventListener('click', galleryItemClick);
	}
}

function initPreviewItems() {
	container.addEventListener('click', galleryPreviewClick);
}

function initAll() {
	initPreviewItems();
	initGalleryItems();
}


initAll();