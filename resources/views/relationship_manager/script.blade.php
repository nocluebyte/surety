@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        let initValidation = function() {
            $('#relationshipManagerForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('.type').prop('disabled', false)
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
            });
        };

        $('#country').select2({
            placeholder: 'Select Country',
            allowClear: true,
        });
        $('#state').select2({
            placeholder: 'Select State',
            allowClear: true,
        });

        $('#country').on('select2:select', function() {
            var countryName = $('#country').find("option:selected").text();
            checkPinCodeValidation('jsPinCode', 'post_code', countryName);
        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });

        var id = $('#id').val();
        if (id > 0) {
            var isrepeater = false;
        } else {
            var isrepeater = true;
        }

        $('#rmUsersRepeater').repeater({
            initEmpty: isrepeater,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                let newRow = $(this);
                let selectedOption = $(".jsUser").find(':selected');
                let rm_user_id = selectedOption.val();
                let user_name = selectedOption.text();

                if (!rm_user_id) {
                    newRow.slideUp(function() {
                        $(this).remove();
                    });
                    return;
                }

                newRow.find('.rm-list-no').text(newRow.index() + 1 + ' .');
                newRow.find('.rm_user_id').val(rm_user_id);
                newRow.find('.user_name').val(user_name);
                
                selectedOption.prop('disabled', true);
                
                $(".jsUser").val('').trigger('change');

                $('.select2-container').css('width', '100%');
                $('.user_count').val(newRow.index());
                newRow.slideDown();
            },
            hide: function(deleteElement) {
                message.fire({
                    title: 'Are you sure',
                    text: "You want to delete this ?",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        var deleted_user_id = $(this).find('.rm_user_id').val();
                        $(".jsUser option[value='" + deleted_user_id + "']").prop('disabled', false);
                        
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.rm-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },

            ready: function(setIndexes) {
                $('.select2-container').css('width', '100%');
            },
            isFirstItemUndeletable: true
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
