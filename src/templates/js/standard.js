var imageArea = document.getElementById('imagearea'),
	image = document.getElementById('image'),
	display = function (file) {
		image.src = 'templates/img/' + file;
		imageArea.style.display = 'inline-block';
	},
	hide = function () {
		imageArea.style.display = 'none';
	}