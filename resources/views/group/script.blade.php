@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();

            if (typeof $('#id').val() != 'undefined' && $('#id').val()) {
                var groupContractorId = $('.contractor_id').val();
                var contractorIds = {{ json_encode($contractorIdArr ?? []) }};
                $('.jscontractor option[value="' + groupContractorId + '"]').prop('disabled', true);

                if (contractorIds) {
                    contractorIds.forEach(bid => {
                        $('.jscontractor option[value="' + bid + '"]').prop('disabled', true);
                    });
                }
            }
        });

        let initValidation = function() {
            jQuery.validator.addClassRules("minDate", {
                min: () => $('.from_date').val()
            });

            $('#groupForm').validate({
                debug: false,
                ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
                rules: {},
                messages: {

                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent()).addClass('text-danger');
                },
                submitHandler: function(e) {
                    $('.jsBtnLoader').addClass('spinner spinner-white spinner-left');
                    $('.jsBtnLoader').prop('disabled', true);
                    return true;
                }
            });
        };

        $(document).on('change', '.from_date', function() {
            var row = $(this).closest('.groupRow');
            var fromDate = moment(row.find('.from_date').val()).format('DD/MM/YYYY');
            row.find('.till_date').attr('data-msg-min', "Please enter a value greater than or equal to " +
                fromDate);
        });

        $('#contractor_id').select2({
            allowClear: true,
        });

        $('#contractor').select2({
            allowClear: true,
        });

        $('.type').select2({
            allowClear: true,
        });

        var groupIds = [];
        var oldGroupId = 0;
        var options = $('.cls-group-contractor option');
        var contractor_id = [];

        $(document).on('change', '.cls-group-contractor', function(e) {
            $('#TableBuilder tr:not(:first)').remove();
            groupIds = [];
            var groupId = $(this).val();
            if (oldGroupId == 0) {
                oldGroupId = groupId;
            } else if (oldGroupId != groupId) {

            }
            groupIds.push(groupId);
            var groupOptions = $('.jscontractor:first option');
            groupOptions.each(function() {
                var gId = $(this).val();
                if ($.inArray(gId, groupIds) != "-1") {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        $(".cls-group-contractor,.jscontractor").on("select2:unselect", function(e) {
            var currentval = ($(this).val());
            var index = groupIds.indexOf(currentval);
            if (index !== -1) {
                groupIds.splice(index, 1);
            }
            var colorOptions = $('.jscontractor option');
            colorOptions.each(function() {
                var colorId = $(this).val();
                if ($.inArray(colorId, groupIds) != "-1") {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });

        $(".contractor_id").change(function(e) {
            var emp_type = $(this).val();
            if (emp_type) {
                $(".group_add").removeClass('disabled');
                $(".jscontractor").addClass('required');
                $(".jscontractor").attr('disabled', false);

            } else {
                $(".group_add").addClass('disabled');
                $(".jscontractor").removeClass('required');
                $(".jscontractor").attr('disabled', true);
            }
        });

        var contractorId = {{ isset($groupcontractor) ? $groupcontractor->pluck('id') : '[]' }};

        $(document).on('click', '.group_add', function(e) {
            var bId = $(".jscontractor").select2('val');
            var _ths = $(this);

            if (bId) {
                contractorId.push(bId);

                if (contractorId.length >= 1) {
                    $(".disaRemoveSave").removeAttr('disabled');
                    $(".disaRemoveSaveExit").removeAttr('disabled');

                }
                if (contractorId) {
                    $(".jscontractor").removeClass('required');
                }
                $.ajax({
                    url: "{{ route('contractor-name-group') }}",
                    type: 'GET',
                    data: {
                        id: bId
                    },
                    success: function(response) {
                        var trHTML = '';

                        $.each(response, function(i, item) {
                            $('#TableBuilder').append(item);
                        });

                        $(".jscontractor > option").attr("disabled", function() {
                            return contractorId.includes($(this).val());
                        });
                        $("#contractor")[0].selectedIndex = 0;
                        $("#contractor").select2();
                        $(".type").select2({
                            allowClear: true
                        });

                        groupIds.push(bId);
                        var colorOptions = $('.jscontractor option');
                        colorOptions.each(function() {
                            var colorId = $(this).val();
                            // console.log(colorId);
                            // console.log(groupIds);
                            // console.log($.inArray(colorId, groupIds));
                            if ($.inArray(colorId, groupIds) != "-1") {
                                $(this).prop('disabled', true);
                            } else {
                                $(this).prop('disabled', false);
                            }
                        });
                    }
                });
            }
        });

        $(document).on('click', '.jsDeleteGroup', function(e) {
            var contractorIdDelete = $(this).data('contractorid');
            var index = contractorId.indexOf(contractorIdDelete);
            if (index == -1) {
                contractorId.splice(index, 1);

            }
            if (contractorId.length <= 0) {
                $(".disaRemoveSave").attr("disabled", true);
                $(".disaRemoveSaveExit").attr("disabled", true);

            }

            $('.jscontractor option[value="' + contractorIdDelete + '"]').prop('disabled', false);
            var index = groupIds.indexOf(contractorIdDelete);
            if (index >= 0) groupIds.splice(index, 1);
            $("#contractor").select2();
            $(".type").select2();

            $(this).closest('tr').remove();

        });

        $(document).on('click', '#btn_loader_save', function() {
            $('.jsSaveType').val('save');
        });
        $(document).on('click', '#btn_loader', function() {
            $('.jsSaveType').val('save_exit');
        });
    </script>
    {!! ajax_fill_dropdown('country_id', 'state_id', route('get-states')) !!}
@endpush
