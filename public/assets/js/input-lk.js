document.addEventListener("DOMContentLoaded", function () {
    // Handle dropdown selection
    const dropdownItems = document.querySelectorAll(".dropdown-item");
    const dropdownButton = document.getElementById("dropdownMenuButton1");

    dropdownItems.forEach((item) => {
        item.addEventListener("click", function () {
            dropdownButton.textContent = item.textContent; // Update button text
        });
    });
});
