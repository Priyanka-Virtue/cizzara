const checkboxes = document.querySelectorAll('input[name="selectedRecords[]"]');
const selectAllCheckbox = document.getElementById("selectAll");
const selectAllPagesButton = document.getElementById("selectAllPages");

// Function to toggle select all checkboxes
function toggleSelectAll() {
    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

// Event listener for main checkbox
selectAllCheckbox.addEventListener("change", toggleSelectAll);

const exportForm = document.getElementById("exportForm");
const exportButton = document.getElementById("exportButton");

exportButton.addEventListener("click", function (event) {
    event.preventDefault();
    const selectedRecordIds = Array.from(
        document.querySelectorAll('input[name="selectedRecords[]"]:checked')
    ).map((checkbox) => checkbox.value);
    const formData = new FormData();
    selectedRecordIds.forEach((id) => formData.append("selectedRecords[]", id));
    const csrfToken = exportForm.querySelector('input[name="_token"]').value;
    formData.append("_token", csrfToken);

    exportExcel(formData);
});
$("#selectAllPages").on("click", function (event) {
    event.preventDefault();

    const formData = new FormData();
    const csrfToken = exportForm.querySelector('input[name="_token"]').value;
    formData.append("_token", csrfToken);
    exportExcel(formData);
});

function exportExcel(formData) {
    // Serialize selected record IDs and append to form data
    // const selectedRecordIds = Array.from(document.querySelectorAll('input[name="selectedRecords[]"]:checked'))
    //     .map(checkbox => checkbox.value);
    // const formData = new FormData();
    // selectedRecordIds.forEach(id => formData.append('selectedRecords[]', id));
    // formData.append('_token', '{{ csrf_token() }}');
    // Send AJAX request to export records
    fetch(exportForm.action, {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            // Handle response - e.g., show success message or trigger file download
            if (response.ok) {
                // Trigger file download
                response.blob().then((blob) => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = url;
                    a.download = "cizzara.xlsx";
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                });
            } else {
                console.error("Export failed:", response.statusText);
            }
        })
        .catch((error) => {
            console.error("Export error:", error);
        });
}
