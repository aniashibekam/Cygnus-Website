document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const mainNav = document.getElementById("mainNav");

    // Pages without the shared navigation can safely load this script.
    if (!menuToggle || !mainNav) return;

    function setMenuOpen(isOpen) {
        mainNav.classList.toggle("open", isOpen);
        menuToggle.setAttribute("aria-expanded", String(isOpen));
        menuToggle.setAttribute(
            "aria-label",
            isOpen ? "Close navigation menu" : "Open navigation menu"
        );
        menuToggle.textContent = isOpen ? "✕" : "☰";
    }

    menuToggle.addEventListener("click", function () {
        const isOpen = menuToggle.getAttribute("aria-expanded") === "true";
        setMenuOpen(!isOpen);
    });

    mainNav.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", function () {
            setMenuOpen(false);
        });
    });

    document.addEventListener("click", function (event) {
        const clickedInsideNav = mainNav.contains(event.target);
        const clickedToggle = menuToggle.contains(event.target);

        if (!clickedInsideNav && !clickedToggle) {
            setMenuOpen(false);
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            setMenuOpen(false);
            menuToggle.focus();
        }
    });

    // Keep the mobile menu closed when returning to desktop width.
    window.addEventListener("resize", function () {
        if (window.innerWidth > 700) {
            setMenuOpen(false);
        }
    });
});
