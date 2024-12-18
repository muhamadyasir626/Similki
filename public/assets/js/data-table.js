// npm package: datatables.net-bs5
// github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5

$(function () {
    "use strict";

    $(function () {
        $("#dataTableExample").DataTable({
            aLengthMenu: [
                [10, 30, 50, -1],
                [10, 30, 50, "All"],
            ],
            iDisplayLength: 10,
            language: {
                search: "",
            },
        });
        $("#dataTableExample").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });
    });
});

//export
// Tambahkan kode berikut pada file data-table.js
$(document).ready(function () {
    // Tambahkan event listener pada tombol export file
    $("#export-csv, #export-pdf, #export-excel, #export-print").on(
        "click",
        function () {
            // Aktifkan checkbox
            $(".selectRow").prop("disabled", false);
            var type = $(this).attr("id").replace("export-", "");
            var selectedRows = [];
            $(".selectRow:checked").each(function () {
                selectedRows.push($(this).val());
            });
            exportData(type, selectedRows);
            // Nonaktifkan checkbox setelah export
            $(".selectRow").prop("disabled", true);
        }
    );

    // Fungsi untuk export data
    function exportData(type, selectedRows) {
        $.ajax({
            type: "POST",
            url: "/export-data",
            data: { type: type, selectedRows: selectedRows },
            success: function (response) {
                switch (type) {
                    case "csv":
                        exportToCSV(response.data);
                        break;
                    case "pdf":
                        exportToPDF(response.data);
                        break;
                    case "excel":
                        exportToExcel(response.data);
                        break;
                    case "print":
                        exportToPrint(response.data);
                        break;
                }
            },
        });
    }

    // Fungsi untuk export data ke CSV
    function exportToCSV(data) {
        var csvContent =
            "Nama Panggilan,Asal Satwa,Jenis Koleksi,Spesies,Status Perlindungan\n";
        data.forEach(function (row) {
            csvContent +=
                row.nama_panggilan +
                "," +
                row.asal_satwa +
                "," +
                row.jenis_koleksi +
                "," +
                row.spesies +
                "," +
                row.status_perlindungan +
                "\n";
        });
        var encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "data.csv");
        link.click();
    }

    // Fungsi untuk export data ke PDF
    function exportToPDF(data) {
        var pdf = new jsPDF();
        var pdfContent = [];
        data.forEach(function (row) {
            pdfContent.push([
                row.nama_panggilan,
                row.asal_satwa,
                row.jenis_koleksi,
                row.spesies,
                row.status_perlindungan,
            ]);
        });
        pdf.autoTable({
            head: [
                [
                    "Nama Panggilan",
                    "Asal Satwa",
                    "Jenis Koleksi",
                    "Spesies",
                    "Status Perlindungan",
                ],
            ],
            body: pdfContent,
        });
        pdf.save("data.pdf");
    }

    // Fungsi untuk export data ke Excel
    function exportToExcel(data) {
        var worksheet = XLSX.utils.json_to_sheet(data);
        var workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Data Satwa");
        XLSX.writeFile(workbook, "data.xlsx");
    }

    // Fungsi untuk print data
    function exportToPrint(data) {
        var printWindow = window.open("", "", "height=600,width=800");
        printWindow.document.write(
            "<html><head><title>Print Data</title></head><body>"
        );
        printWindow.document.write("<h1>Data Satwa</h1>");
        printWindow.document.write(
            '<table border="1"><tr><th>Nama Panggilan</th><th>Asal Satwa</th><th>Jenis Koleksi</th><th>Spesies</th><th>Status Perlindungan</th></tr>'
        );
        data.forEach(function (row) {
            printWindow.document.write(
                "<tr><td>" +
                    row.nama_panggilan +
                    "</td><td>" +
                    row.asal_satwa +
                    "</td><td>" +
                    row.jenis_koleksi +
                    "</td><td>" +
                    row.spesies +
                    "</td><td>" +
                    row.status_perlindungan +
                    "</td></tr>"
            );
        });
        printWindow.document.write("</table></body></html>");
        printWindow.print();
        printWindow.close();
    }
});
