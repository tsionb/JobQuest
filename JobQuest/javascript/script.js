document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("adminForm");

    form.addEventListener("submit", function (event) {
        let valid = true;
        const errorMessages = document.querySelectorAll(".error-message");

        // Clear previous error messages
        errorMessages.forEach((error) => (error.textContent = ""));

        // Name Validation
        const name = document.getElementById("name");
        if (name.value.trim() === "") {
            showError(name, "Name is required.");
            valid = false;
        }

        // Email Validation
        const email = document.getElementById("email");
        if (!validateEmail(email.value)) {
            showError(email, "Invalid email format.");
            valid = false;
        }

        // Password Validation
        const password = document.getElementById("password");
        if (password.value.length < 6) {
            showError(password, "Password must be at least 6 characters.");
            valid = false;
        }

        // Admin Code Validation
        const adminCode = document.getElementById("admin_code");
        if (adminCode.value.trim() === "") {
            showError(adminCode, "Admin Code is required.");
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });

    // Function to display an error message
    function showError(input, message) {
        const errorMessage = input.nextElementSibling;
        errorMessage.textContent = message;
        errorMessage.style.display = "block";
    }

    // Function to validate email format
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
