document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the form from submitting

    // Get username and password
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Your login logic here (e.g., check username and password)

    // Simulate successful login for demonstration purposes
    if (username === "admin" && password === "admin123") {
        // Redirect to admin panel
        window.location.href = "admin_panel.html";
    } else {
        // Show an error message (you can customize this part)
        alert("Invalid username or password. Please try again.");
    }
});