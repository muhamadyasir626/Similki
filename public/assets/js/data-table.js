// npm package: datatables.net-bs5
// github link: https://github.com/DataTables/Dist-DataTables-Bootstrap5

$(function() {
  'use strict';

  $(function() {
    $('#dataTableExample').DataTable({
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "iDisplayLength": 50,
      "language": {
        search: ""
      }
    });
    $('#dataTableExample').each(function () {
      var datatable = $(this);

      // SEARCH - Add the placeholder for Search and Turn this into in-line form control
      var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
      search_input.attr('placeholder', 'Cari di tabel ini');
      search_input.removeClass('form-control-sm');

      // LENGTH - Inline-Form control
      var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
      length_sel.removeClass('form-control-sm');

      // Pindahkan pencarian ke dalam .searchbar
      var searchbar = $('.searchbar');
      if (searchbar.length) {
          // Tambahkan input pencarian bawaan DataTables ke dalam .searchbar
          var search_wrapper = datatable.closest('.dataTables_wrapper').find('div[id$=_filter]');
          searchbar.append(search_wrapper);
      }
  });
  });

});