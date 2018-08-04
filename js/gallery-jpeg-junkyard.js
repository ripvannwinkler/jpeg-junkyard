var gallery = [].slice.call(document.querySelectorAll(".jj-gallery-item a:nth-child(2)"));
var container = document.querySelector(".jj-image-container");

nextInterval = 0;

function setPreviewImage(url) {
	container.classList.remove("fade-in");
	var img = document.createElement("img");
	img.addEventListener("load", function (e) {
		var bg = "url(" + url + ")";
		container.style.backgroundImage = bg;
		container.classList.add("fade-in");
		startSlides();
	});

	img.src = url;
}

function getIndexByUrl() {
	var expr = /url\((.+)\)/gi;
	var style = container.style.backgroundImage;
	var match = expr.exec(style);
	var url = match[1];

	url = url.replace(/["']/gi, "");
	for (var i = 0; i < gallery.length; i++) {
		var href = gallery[i].getAttribute("href");
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
	document.addEventListener('click', function (e) {
		if (e.originalTarget.parentNode.dataset.attachmentId) {
			e.preventDefault();
			e.stopPropagation();
			setPreviewImage(e.originalTarget.parentNode.href);
		}
	})
	// for (var i = 0; i < gallery.length; i++) {
	// 	var item = gallery[i];
	// 	item.addEventListener("click", galleryItemClick);
	// }
}

function initPreviewItems() {
	container.addEventListener("click", galleryPreviewClick);
}

function startSlides() {
	clearTimeout(nextInterval);
	nextInterval = setTimeout(function () {
		galleryPreviewNext();
	}, 5000);
}

function initAll() {
	initPreviewItems();
	initGalleryItems();
	startSlides();
}

initAll();