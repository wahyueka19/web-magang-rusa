function getId(url) {
	const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
	const match = url.match(regExp);

	return match && match[2].length === 11 ? match[2] : null;
}

function validate() {
	var getLink = getId(document.getElementById("link").value);
	var ret = getLink.replace("https://www.youtube.com/watch?v=", "");
	return ret;
}

function showVideo() {
	var videoUrl = "//www.youtube.com/embed/" + validate();
	var warn = document.getElementById("warn");
	var vid = document.getElementById("vid");

	if (
		videoUrl == "" ||
		videoUrl.indexOf("www.youtube.com") < 0 ||
		validate() == null
	) {
		vid.classList.add("d-none");
		warn.classList.replace("d-none", "d-block");
	} else {
		document.getElementById("cekyt").src = videoUrl;
		document.getElementById("link_video").value = validate();
		vid.classList.remove("d-none");
		warn.classList.replace("d-block", "d-none");
	}
}
