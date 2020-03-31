// Call the dataTables jQuery plugin
$(document).ready(function() {
    let table = $('#dataTable').DataTable();

    buildSelect(table);

    table.on('draw', function() {
        buildSelect(table);
    })

    $('#filterByAge').keyup(function () {
       table.draw();
    });
});

function buildSelect( table ) {
    table.columns().every(function() {
        let column = table.column(this, {search: 'applied'});
        let filters = [
            'filterByCase', 'filterByDate', 'filterByAge',
            'filterBySex', 'filterByNationality', 'filterByResidence',
            'filterByHospital', 'filterByTravelHistory', 'filterByStatus',
        ];

        let enabledFilters = [3, 4, 5, 6, 7, 8];

        if (enabledFilters.indexOf(column.index()) > -1) {
            let filterId = filters[column.index()];

            let select = $(
                '<select class="form-control">' +
                '<option value="">Select All</option>' +
                '</select>'
                )
                .appendTo($('#' + filterId).empty())
                .on('change', function () {
                    let val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                });

            column.data().unique().sort().each( function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
            });

            // The rebuild will clear the existing select, so it needs to be repopulated
            let currSearch = column.search();
            if (currSearch) {
                select.val(currSearch.substring(1, currSearch.length - 1));
            }
        }

    } );
}
