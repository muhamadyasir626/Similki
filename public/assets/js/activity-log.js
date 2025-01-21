// Dummy data
const activityLog = [
    {
        user: "Novia Dwi Lestari",
        action: "Updated profile",
        timestamp: "20 December 2024, 10:30 AM",
    },
    {
        user: "John Doe",
        action: "Uploaded a document",
        timestamp: "20 December 2024, 09:15 AM",
    },
    {
        user: "Jane Smith",
        action: "Logged in",
        timestamp: "19 December 2024, 11:45 PM",
    },
    {
        user: "Alex Brown",
        action: "Changed password",
        timestamp: "19 December 2024, 08:20 PM",
    },
    {
        user: "Chris Taylor",
        action: "Deleted an entry",
        timestamp: "18 December 2024, 02:10 PM",
    },
];

// Populate table
const tableBody = document.querySelector("#activityTable tbody");

activityLog.forEach((log, index) => {
    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${log.user}</td>
        <td>${log.action}</td>
        <td class="timestamp">${log.timestamp}</td>
        <td><button class="btn-see-changes" onclick="seeChanges(${index})">Log</button></td>
    `;

    tableBody.appendChild(row);
});

// See Changes handler
function seeChanges(index) {
    const log = activityLog[index];
    document.getElementById("popupUser").textContent = `User: ${log.user}`;
    document.getElementById(
        "popupAction"
    ).textContent = `Action: ${log.action}`;
    document.getElementById(
        "popupTimestamp"
    ).textContent = `Timestamp: ${log.timestamp}`;
    document.getElementById("overlay").style.display = "block";
    document.getElementById("popup").style.display = "block";
}

// Close Popup
function closePopup() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
}
