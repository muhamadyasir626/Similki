const dropArea = document.getElementById("drop-area");
const fileInput = document.getElementById("fileElem");
const preview = document.getElementById("preview");

["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
    dropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
});

["dragenter", "dragover"].forEach((eventName) => {
    dropArea.addEventListener(
        eventName,
        () => dropArea.classList.add("hover"),
        false
    );
});

["dragleave", "drop"].forEach((eventName) => {
    dropArea.addEventListener(
        eventName,
        () => dropArea.classList.remove("hover"),
        false
    );
});

dropArea.addEventListener(
    "drop",
    (e) => handleFiles(e.dataTransfer.files),
    false
);
dropArea.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", () => handleFiles(fileInput.files));

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function handleFiles(files) {
    if (files && files.length > 0) {
        const file = files[0];
        console.log("Selected file:", file);

        if (file.type === "text/csv" || file.name.endsWith(".csv")) {
            const reader = new FileReader();
            reader.onload = (event) => {
                preview.innerHTML = parseCSV(event.target.result);
            };
            reader.onerror = () =>
                alert("Error reading file. Please try again.");
            reader.readAsText(file);
        } else {
            alert("Please upload a valid CSV file.");
        }
    } else {
        alert("No file selected.");
    }
}

function parseCSV(data) {
    const rows = data.split("\n");
    let html = "<table>";
    rows.forEach((row) => {
        html += "<tr>";
        row.split(",").forEach((cell) => (html += `<td>${cell.trim()}</td>`));
        html += "</tr>";
    });
    html += "</table>";
    return html;
}

const submitButton = document.getElementById("submitFile");

submitButton.addEventListener("click", () => {
    const fileInput = document.getElementById("fileElem");
    const files = fileInput.files;

    if (!files || files.length === 0) {
        alert("Please select a file before submitting.");
        return;
    }

    const file = files[0];

    if (file.type === "text/csv" || file.name.endsWith(".csv")) {
        alert(`Submitting file: ${file.name}`);
    } else {
        alert("Invalid file type. Please select a valid CSV file.");
    }
});
