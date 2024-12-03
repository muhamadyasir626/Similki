document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("change", function (event) {
        console.log('test');
        if (event.target.classList.contains("toggle-class")) {
            event.stopImmediatePropagation();
            event.preventDefault();

            const toggle = event.target; // Ambil elemen toggle
            const status = toggle.checked ? 1 : 0;
            const userId = toggle.dataset.id;

            console.log(`User ID: ${userId}, Status: ${status}`);

            // Kirim permintaan menggunakan fetch
            fetch(`/updated-permission/${userId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ status: status })
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log('Permission updated successfully:', data);
                        if (status === 1) {
                            $(toggle).bootstrapToggle('on');
                        } else {
                            $(toggle).bootstrapToggle('off');
                        }
                    } else {
                        console.error('Failed to update permission on server.');
                        $(toggle).bootstrapToggle(status ? 'off' : 'on');
                    }
                })
                .catch((error) => {
                    console.error('Fetch Error:', error);
                    $(toggle).bootstrapToggle(status ? 'off' : 'on');
                });
        }
    });
});
