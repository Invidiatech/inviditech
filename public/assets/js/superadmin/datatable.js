// Remove all other DataTable initializations and use only this one
$(document).ready(function() {
    // Only initialize if the table exists
    if ($('#dataTable').length > 0) {
        var table = $('#dataTable').DataTable({
            lengthChange: false,
            order: [],
            dom: 'Bfrtip',
            paging: true,
            ordering: true,
            info: false,
            searching: true,
            columnDefs: [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false
                }
            ],
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Save PDF',
                    className: 'custom-btn',
                    attr: { id: 'pdfBtn' }
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print',
                    className: 'custom-btn',
                    attr: { id: 'printBtn' }
                }
            ],
            initComplete: function() {
                $('#dataTable_filter label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();

                $('#dataTable_filter input')
                    .addClass('custom-search-input')
                    .attr('placeholder', 'Search any thing')
                    .wrap('<div class="custom-search-container"></div>')
                    .after('<i class="fas fa-search search-icon"></i>');
            },
            language: {
                emptyTable: "No data available in table",
                zeroRecords: "No orders found"
            }
        });
    }

// Order status filter handling
if ($('#ordersTable').length > 0) {
    var ordersTable = $('#ordersTable').DataTable();
    $(".filter-btn").click(function() {
        var status = $(this).attr("data-status");
        $(".filter-btn").removeClass("active");
        $(this).addClass("active");
        if (status === "all") {
            ordersTable.search("").columns().search("").draw();
        } else {
            // Change from column index 7 to index 5 (Status column)
            ordersTable.column(4).search(status, true, false).draw();
        }
    });
}
    // Auto hide success message after 3 seconds
    setTimeout(function() {
        $("#success-alert").fadeOut("slow");
    }, 3000);
});
