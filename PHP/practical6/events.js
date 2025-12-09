//mouse event ---- over
function showMenu(e) {
	// e.size = e.options.length;
}

//mouse event ---- out
function hideMenu(e) {
	e.size = 0;
}

//keyboard ---- press
function handleKeyPress(e) {
	console.log("Key Press:", e.key);
}

//kwyboard ---- down
function handleKeyDown(e) {
	console.log("Key Down:", e.key);
}

// window event ---- load
window.addEventListener("load", () => {
	const form = document.forms["applicationForm"];
	const input = document.getElementById("fname");
	console.log(input.style)
	// form subit event
	form.addEventListener("submit", handleForm);
});

// window event ---- scroll
window.addEventListener("scroll", () => {
	console.log("User Scrolled the page");
});

//form event ---- focus
function handleFormFocus(e){
	e.style.outline = "2px solid var(--primary)";
}

//form event ---- blur
function handleFormBlur(e){
	e.style.outline = "";
}

