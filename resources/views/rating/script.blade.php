@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        function updateTabValidation() {
            $('.tab-content.tab-validate .tab-pane').each(function() {

                var id = $(this).attr('id');
                if ($(this).find('input.error, textarea.error, select.error').length) {
                    $('.nav-pills li a[href="#' + id + '"]').addClass('border border-danger');
                } else {
                    $('.nav-pills li a[href="#' + id + '"]').removeClass('border border-danger');
                }
            });
        }

        var initValidation = function() {
            $('#rating').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {
                    name: {
                        required: true,
                    }
                },
                messages: {
                    /*name: {
                        required: "The name field is required.",
                    },*/
                },
                errorPlacement: function(error, element) {
                    // error.appendTo(element.parent()).addClass('text-danger');
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function(e) {
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                },
                invalidHandler: function() {
                    setTimeout(updateTabValidation, 0);
                },
            });
            $('.tab-content.tab-validate').on('input change', 'input, textarea, select', updateTabValidation);
        };

        $('#countryRatingsRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.country-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.country-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: false
        });


        $('#sectorsRatingsRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.sector-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.sector-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: false
        });

        $('#uwViewRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.uwView-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.uwView-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: false
        });

        $('#dateOfEstRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.est-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.est-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: false
        });

        $('#ociEmployeeRepeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).find('.employee-list-no').text($(this).index() + 1 + ' .');
                $(this).slideDown();
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
                        $(this).slideUp(deleteElement);
                        setTimeout(function() {
                            $('.employee-list-no').each(function(index) {
                                $(this).html(index + 1);
                            });
                        }, 500);
                    }
                });
            },
            ready: function(setIndexes) {},
            isFirstItemUndeletable: false
        });
    </script>
@endpush
