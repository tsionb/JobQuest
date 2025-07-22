document.addEventListener("DOMContentLoaded", function () {
    let menuBtn = document.querySelector(".checkbtn");
    let menuCheckbox = document.querySelector("#check");
    let navbar = document.querySelector("nav ul");
    let dropdown = document.querySelector(".dropdown > a");

    // Toggle Navbar on Click
    menuBtn.addEventListener("click", function () {
        menuCheckbox.checked = !menuCheckbox.checked;
    });

    // Close Navbar on Scroll
    window.addEventListener("scroll", function () {
        menuCheckbox.checked = false;
    });

    // Dropdown Click Toggle
    dropdown.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent navigation
        let dropdownMenu = this.nextElementSibling;
        dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
    });
});
