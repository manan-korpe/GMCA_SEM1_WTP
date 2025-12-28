function showToast(type, message) {
    console.log("called");
    const container = document.getElementById("toastContainer");

    // Create new toast
    const toast = document.createElement("div");
    toast.className = "toast t" + type;

    toast.innerHTML = `
        <span>${message}</span>
    `;

    // Add new toast at top
    container.prepend(toast);

    // Remove toast after 3 seconds
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-15px)";
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}