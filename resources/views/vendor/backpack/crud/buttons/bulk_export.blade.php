@if ($crud->hasAccess('create') && $crud->get('list.bulkActions'))
  <a href="javascript:void(0)" onclick="bulkExportEntries(this)" class="btn btn-sm btn-secondary bulk-button"><i class="la la-print"></i> Export</a>
@endif

@push('after_scripts')
<script>
  if (typeof bulkExportEntries != 'function') {
    function bulkExportEntries(button) {

        if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
        {
          new Noty({
                title: "{{ trans('backpack::crud.bulk_no_entries_selected_title') }}",
                text: "{{ trans('backpack::crud.bulk_no_entries_selected_message') }}",
                type: "warning"
            });
          return;
        }

        var message = "Are you sure you want to export these :number entries?";
        message = message.replace(":number", crud.checkedItems.length);

        // show confirm message
        if (confirm(message) == true) {
            var ajax_calls = [];
            var export_route = "{{ url($crud->route) }}/bulk-export";

        // submit an AJAX delete call
        $.ajax({
          url: export_route,
          type: 'POST',
          data: { entries: crud.checkedItems },
          success: function(result) {
            // Show an alert with the result
            new Noty({
                title: "Entries exported",
                text: crud.checkedItems.length+" new entries have been exported.",
                type: "success"
            });

            crud.checkedItems = [];
            crud.table.ajax.reload();
          },
          error: function(result) {
            // Show an alert with the result
            new Noty({
                title: "Exporting failed",
                text: "One or more entries could not be exported. Please try again.",
                type: "warning"
            });
          }
        });
        }
      }
  }
</script>
@endpush