@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#principle_import_form').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {

                },
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                }
            });

            $('.jsexport_error_table').dataTable({
                searching: false,
                ordering: false,
                dom: `<'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                oLanguage: {
                    "sLengthMenu": "Display &nbsp;_MENU_",
                },
                stateSave: false,
                // responsive: true,
                colReorder: true,
                scrollX: true,
                buttons: [],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100, 250],

                dom: `Bfrt<'row'<'col-sm-6 col-md-6'i><'col-sm-6 col-md-6 dataTables_pager'lp>>`,
            });
        });
    </script>
@endpush
