@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            initValidation();
        });

        var initValidation = function() {
            $('#premiumForm').validate({
                debug: false,
                ignore: '.select2-search__field, :hidden:not("textarea,.files,select,input")',
                rules: {
                    payment_received_date: {
                        min: moment().subtract(30, 'days').format('YYYY-MM-DD'),
                        max: moment().add(30, 'days').format('YYYY-MM-DD'),
                    },
                },
                messages: {
                    payment_received_date: {
                        min: () => "Please enter a value greater than or equal to " + moment().subtract(30, 'days').format('DD/MM/YYYY'),
                        max: () => "Please enter a value less than or equal to " + moment().add(30, 'days').format('DD/MM/YYYY'),
                    },
                },
                errorPlacement: function(error, element) {
                    if (element.parent().hasClass('input-group')) {
                        error.appendTo(element.parent().parent()).addClass('text-danger');
                    } else {
                        error.appendTo(element.parent()).addClass('text-danger');
                    }
                },
                submitHandler: function() {
                    $('.tender_id').prop('disabled', false);
                    $('.beneficiary_id').prop('disabled', false);
                    $('.jsReadOnly').attr('readonly', false);
                    $('.jsDisabled').attr('disabled', false);
                    $('#btn_loader').addClass('spinner spinner-white spinner-left');
                    $('#btn_loader').prop('disabled', true);
                    return true;
                },
            });

            $(document).on('change', '.bond_type', function() {
            var bond_type = $(this).val();
            $(".proposal_id option").remove();
            var s = $(".proposal_id");
            if(bond_type > 0) {
                addLoadSpiner(s);
                var ajaxUrl = $(this).attr('data-ajaxurl');
                $.ajax({
                    type: "GET",
                    url: ajaxUrl,
                    data: {
                        'bond_type': bond_type,
                    },
                }).always(function() {

                }).done(function(response) {
                   hideLoadSpinner(s); 
                   if(response){
                        var options = '';
                        var selected = '';
                        $.each(response,function(index,val){
                                options += '<option '+selected+' value = '+val.id+' data-bond_value='+val.bond_value+' data-version='+val.version+'>'+val.code+'/V'+ val.version+'</option>';
                        });
                        $('.proposal_id').html("<option value = ''>Select Type</option>").append(options);
                        $('.proposal_id').select2({ allowClear:true});
                   }                  
                });
            } else {
                $(".proposal_id option").remove();
            }
        });

            $(document).on('change', '.proposal_id', function() {
                $('.contractor_data').empty();
                $('input.contractor_data').remove();
                let code = $(this).find(":selected").text();

                let proposal_id = $(this).val();

                if (proposal_id.length == 0) {
                    $('.contractor_data').empty();
                    $('input.contractor_data').remove();
                }

                if (proposal_id > 0) {
                    let ajaxUrl = $(this).attr('data-ajaxurl');

                    $.ajax({
                        type: "GET",
                        url: ajaxUrl,
                        data: {
                            'code': code,
                            'proposal_id': proposal_id,
                        },
                    }).always(function() {

                    }).done(function(response) {
                        console.log(response);
                        if (response) {
                            $(".bond_value").val(response.bond_value);
                            $(".bond_value").prop('readonly', true).addClass('form-control-solid');

                            $('select[name="tender_id"]').val(response.tender_id).trigger(
                                'change');
                            $('select[name="tender_id"]').prop('disabled', true).addClass(
                                'form-control-solid');

                            $('select[name="beneficiary_id"]').val(response.beneficiaryID).trigger(
                                'change');
                            $('select[name="beneficiary_id"]').prop('disabled', true).addClass(
                                'form-control-solid');

                            response.contractor_ids.forEach(field => {
                                $('<input>').attr({
                                    type: 'hidden',
                                    class: 'contractor_data',
                                    name: 'contractor_data[][contractorID]',
                                    value: field
                                }).appendTo('form');
                            });

                            const cards = response.contractor_name.map(field =>
                                `<div class="card mb-5" style="width:50%;">
                                    <div class="card-body p-5">
                                        ${field}
                                    </div>
                                </div>`
                            ).join('');

                            $('.contractor_data').html(cards);

                        } else {
                            $(".bond_value").val("");
                            $(".bond_value").prop('readonly', false).removeClass('form-control-solid');
                        }
                    })
                }
            });

            $(document).on('click', '#btn_loader_save', function() {
                $('.jsSaveType').val('save');
            });
            $(document).on('click', '#btn_loader', function() {
                $('.jsSaveType').val('save_exit');
            });
        };
    </script>
@endpush
