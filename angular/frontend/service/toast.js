app.service("ToastService", function($timeout) {

    this.show = function(type, message) {
        const container = document.getElementById("toastContainer");

        const toast = document.createElement("div");
        toast.className = "toast t" + type;
        toast.innerHTML = `<span>${message}</span>`;

        container.prepend(toast);

        $timeout(() => {
            toast.style.opacity = "0";
            toast.style.transform = "translateY(-15px)";
            $timeout(() => toast.remove(), 300);
        }, 3000);
    };

});
