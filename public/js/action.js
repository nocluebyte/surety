$(document).ready(function () {
    $('.jsSelect2').select2();
    $('.jsSelect2ClearAllow').select2({allowClear:true});
    $(document).on('click', '.delete-confrim', function (e) {
        e.preventDefault();

        var el = $(this);
        var url = el.attr('href');
        var redirect = el.attr('data-redirect');
        var id = el.data('id');
        var refresh = '#'+el.data().table;
       console.log(refresh);
       // return false;

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
                //showLoader();
                $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    data: {
                        id: id,
                        _method: 'DELETE'
                    }
                }).always(function (respons) {
                    //stopLoader();
                     if(redirect)
                    {   
                        if(respons.success) {
                            window.location = redirect;
                        }
                    } else {
                        if(respons.page_refresh) {
                            location.reload();
                        } else {
                            // window.location.href = redirect;
                            $(refresh).DataTable().ajax.reload();
                        } 
                    } 
                    
                }).done(function (respons) {
                    if(respons.success) {
                        toastr.success(respons.message, "Success");
                    } else {
                        toastr.error(respons.message, "Error");
                    }
                }).fail(function (respons) {
                    var res = respons.responseJSON;
                    var msg = 'something went wrong please try again !' ;

                    if(res.errormessage) {
                        toastr.warning(res.errormessage, "Warning");
                    }
                    toastr.error(msg, "Error");
                });
            }
        });

    });
    //Function for take confirmation from admin user to unassign employee to class and subject and also use for get method route
    $(document).on('click', '.action-confrim', function (e) {
        e.preventDefault();

        var el = $(this);
        var url = el.attr('href');
        var refresh = el.closest('table');
        //console.log(refresh);
       // alert(refresh);
       // return false;
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

                //showLoader();
                $.ajax({
                    type: "GET",
                    url: url,
                    cache: false
                }).always(function (respons) {
                    $(refresh).DataTable().ajax.reload();

                }).done(function (respons) {

                    message.fire({
                        type: 'success',
                        title: 'Success',
                        text: respons.message
                    });

                }).fail(function (respons) {
                    var data = respons.responseJSON;
                    message.fire({
                        type: 'error',
                        title: 'Error',
                        text: data.message ? data.message :
                            'something went wrong please try again !'
                    });

                });
            }
        });

    });
    //End of above
    $(document).on('click', '.change-status', function (e) {

        var el = $(this);
        var url = el.data('url');
        var table = el.data('table');
        var id = el.val();
        var refresh = el.data().table;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id,
                status: el.prop("checked"),
                table: table,
            }
        }).always(function (respons) { }).done(function (respons) {

            // if (refresh == 'categories') {
            //     $('#'+refresh).DataTable().ajax.reload();
            // }
            $('#dataTableBuilder').DataTable().ajax.reload();
            message.fire({
                type: 'success',
                title: 'Success',
                text: respons.message
            });

        }).fail(function (respons) {
            if (el.prop("checked") == true) {
                el.prop("checked", false);
            } else {
                el.prop("checked", true);
            }
            message.fire({
                type: 'error',
                title: 'Error',
                text: (typeof respons.responseJSON.message != 'undefined') ? respons.responseJSON.message : 'something went wrong please try again !'
            });

        });

    });

    $(document).on('click', '.change-inactive-status', function (e) {

        var el = $(this);
        var url = el.data('url');
        var table = el.data('table');
        var id = el.val();
        var refresh = el.data().table;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id,
                status: el.prop("checked"),
                table: table,
            }
        }).always(function (respons) { }).done(function (respons) {

            // if (refresh == 'categories') {
            //     $('#'+refresh).DataTable().ajax.reload();
            // }
            $('#dataTableBuilder').DataTable().ajax.reload();
            if(el.prop("checked") == true) {
                message.fire({
                    type: 'success',
                    title: 'Success',
                    text: respons.message
                });
            }
            

        }).fail(function (respons) {
            if (el.prop("checked") == true) {
                el.prop("checked", false);
            } else {
                el.prop("checked", true);
            }
            message.fire({
                type: 'error',
                title: 'Error',
                text: (typeof respons.responseJSON.message != 'undefined') ? respons.responseJSON.message : 'something went wrong please try again !'
            });

        });

    });

    $(document).on('click', '.change-employee-status', function (e) {

        var el = $(this);
        var url = el.data('url');
        var table = el.data('table');
        var id = el.val();
        var refresh = el.data().table;
        var status = el.prop("checked");

        var statusChange = false;
        if(status == false){
            $(".employee-left").trigger('click');
            setTimeout(function () {
                $("#empId").val(id);
            }, 800);    
        } else {
            statusChange = true;
        }
         
        if(statusChange){
            $.ajax({    
                type: "POST",
                url: url,
                data: {
                    id: id,
                    status: el.prop("checked"),
                    table: table,
                }
            }).always(function (respons) { }).done(function (respons) {
                if (refresh == 'categories') {
                    $('#'+refresh).DataTable().ajax.reload();
                }
                message.fire({
                    type: 'success',
                    title: 'Success',
                    text: respons.message
                });
            }).fail(function (respons) {
                if (el.prop("checked") == true) {
                    el.prop("checked", false);
                } else {
                    el.prop("checked", true);
                }
                message.fire({
                    type: 'error',
                    title: 'Error',
                    text: (typeof respons.responseJSON.message != 'undefined') ? respons.responseJSON.message : 'something went wrong please try again !'
                });

            });
        }

    });

    $(document).on('click', '.call-modal', function (e) {
        e.preventDefault();
        // return false;
        var el = $(this);
        var url = el.data('url');
        var target = el.data('target-modal');
        var footerHide = el.data('footer-hide');

        $.ajax({
            type: "GET",
            url: url
        }).always(function () {
            $('#load-modal').html(' ')
            $('.modal-footer').show();
        }).done(function (res) {
            $('#load-modal').html(res.html);
            $(target).modal('toggle');
            if (footerHide) {
                $('.modal-footer').hide();
            }
        });
    });

    $(document).on('click', '.call-so-modal', function (e) {
        e.preventDefault();
        var el = $(this);
        var url = el.attr('data-url');
        var target = el.data('target-modal');
        var footerHide = el.data('footer-hide');

        $.ajax({
            type: "GET",
            url: url
        }).always(function () {
            $('#load-modal').html(' ')
            $('.modal-footer').show();
        }).done(function (res) {
            $('#load-modal').html(res.html);
            $(target).modal('toggle');
            if (footerHide) {
                $('.modal-footer').hide();
            }
        });
    });

    $(document).on('click', ".show-info", function() {
        var infoUrl = $(this).data('url');
        var tableName = $(this).data('table');
        var tableRowId = $(this).data('id');
        $.ajax({
            type: "GET",
            url: infoUrl,
            cache: false,
            data: {
                table_name : tableName,
                id: tableRowId,
            },
            success:function(response){
                console.log(response);
                $("#created_at").html(response.addData.created_at);
                $("#created_by").html(response.addData.created_by);
                $("#created_ip").html(response.addData.created_ip);

                $("#updated_at").html(response.updateData.updated_at);
                $("#updated_by").html(response.updateData.updated_by);
                $("#updated_ip").html(response.updateData.updated_ip);
            }
        });
    });

    $(document).on('change', '.additional_bond_id', function() {
        var additional_bond_id = $(this).val();
        var proposal_id = $('.proposal_id').val();
        if(additional_bond_id > 0 && proposal_id > 0){
            var ajaxUrl = $(this).attr('data-ajaxurl');
            $.ajax({
                type: "GET",
                url: ajaxUrl,
                data: {
                    'additional_bond_id': additional_bond_id,
                    'proposal_id': proposal_id,
                },
            }).always(function() {

            }).done(function(response) {
                if (response) {
                    $(".bond_value").val(response.bond_value);                
                } else {
                    $(".bond_value").val(''); 
                    $(".tender_id").val('').change();                   
                }
            });
        } else {
            $(".bond_value").val('');  
            $(".tender_id").val('').change();
        }
    });

    //For Date Filter-------------------------------------------
    var start = moment().subtract(29, 'days');
    var end = moment();

    var financial_start = moment().startOf('quarter');
    var financial_end = moment().startOf('quarter').add(1,'years').subtract(1, 'days');

    $('.from_to_datepicker').daterangepicker({
     buttonClasses: ' btn',
     applyClass: 'btn-primary',
     cancelClass: 'btn-secondary',
     locale: {
        format: 'DD/MM/YYYY'
    },
     startDate: start,
     endDate: end,

     ranges: {
     'Today': [moment(), moment()],
     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
     'Last 7 Days': [moment().subtract(6, 'days'), moment()],
     'Last 30 Days': [moment().subtract(29, 'days'), moment()],
     'This Month': [moment().startOf('month'), moment().endOf('month')],
     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
     'This Year': [moment().startOf('quarter'), moment().startOf('quarter').add(1,'years').subtract(1, 'days')],
     'Last Year': [financial_start.subtract(1, 'year'), financial_end.subtract(1, 'year')],
     // 'This Year': [moment().startOf('year'), moment().endOf('year')],
     // 'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
     }
    }, function(start, end, label) {
     $('.from_to_datepicker .form-control').val( start.format('DD-MM-YYYY') + ' | ' + end.format('DD-MM-YYYY'));
    });
    //For Date Filter-------------------------------------------

    //For Default Year wise Datepicker Filter-------------------------------------------
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    var filteredDate = $('#date').val();
    if (filteredDate) {
        var filteredDateArr = $('#date').val().split(' | ');
        var filteredFromDate = filteredDateArr[0];
        var filteredToDate = filteredDateArr[1];
        var start = filteredFromDate;
        var end = filteredToDate;
    }
    var fromYearDate = new Date(defaultFromDate);
    var toYearDate = new Date(defaultToDate);

    $('.datepicker_filter').daterangepicker({
        buttonClasses: ' btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [fromYearDate, toYearDate],
            'Last Year': [moment(fromYearDate).subtract(1, 'year'), moment(toYearDate).subtract(1, 'year')],
        }
    }, function(start, end, label) {
        $('.datepicker_filter .form-control').val(start.format('DD-MM-YYYY') + ' | ' + end.format(
            'DD-MM-YYYY'));
    });
    //For Default Year wise Datepicker Filter-------------------------------------------

    // $(document).on('click','.dms_attachment_remove',function(){
    //     var url = $(this).attr('data-url');
    //     var id = $(this).attr('data-id');
    //     $(this).closest('tr').remove();
    //     removeDmsAttachment(url,id);
    // });

    $(document).on('click','.dms_attachment_remove',function(){
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        $(this).closest('tr').remove();

        var prefix = $(this).attr('data-prefix');
        var totalLength = $(".dms_" + prefix).find('.dms_attachment_remove').length;
        $('.count_' + prefix).attr('data-count_' + prefix, totalLength);
        getAttachmentsCount(prefix);

        removeDmsAttachment(url,id);
    });

    $(document).on('click','.dms_required_attachment_remove',function(){
        var rc_url = $(this).attr('data-url');
        var rc_id = $(this).attr('data-id');
        $(this).closest('tr').remove();

        var rc_prefix = $(this).attr('data-prefix');
        var rc_totalLength = $(".dms_" + rc_prefix).find('.dms_required_attachment_remove').length;
        if(rc_totalLength == 0){
            $('.' + rc_prefix).addClass('required');
        } else {
            $('.' + rc_prefix).removeClass('required');
        }
        $('.count_' + rc_prefix).attr('data-count_' + rc_prefix, rc_totalLength);
        getAttachmentsCount(rc_prefix);

        removeDmsAttachment(rc_url,rc_id);
    });

    $(document).on('click','.remove_repeater_attachment',function(){
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');

        var rowN = $(this).attr('data-repeater-row');
        var prefix = $(this).attr('data-prefix');

        var rRepeaterItem = $('.remove_repeater_attachment').parents('.' + rowN);

        var rIndex = $(".dms_banking_limits_attachment_" + id).parents('.' + rowN).attr('data-row-index');

        var matchingRow = rRepeaterItem.parent().find('.' + rowN + '[data-row-index="' + rIndex + '"]');

        var remainingLength = matchingRow.find('.count_' + prefix).attr('data-count_' + prefix) - 1;

        matchingRow.find('.count_' + prefix).attr('data-count_' + prefix, remainingLength);

        $(this).closest('tr').remove();
        countRepeaterDocuments(matchingRow.find('#' + prefix), rowN, prefix);

        removeDmsAttachment(url,id);
    });
});

function removeDmsAttachment(url,id){
    $.ajax({
        type: "DELETE",
        url: url,
        cache: false,
        data: {
            id: id,
            _method: 'DELETE'
        }
    });
}

var images = {};
$(document).on('click', '.jsShowDocument', function() {

    var _div = $(this).closest('.jsDivClass');
    var _ths = $('.jsDocument', _div)[0];
    var _prefix = $(this).attr('data-prefix');
    var _deletePrefix = $(this).attr('data-delete');
    var oldCount = $('.length_' + _prefix).attr('data-' + _prefix);
    // alert(oldCount);

    images[_prefix] = [];

    var length = _ths.files.length;
    if (length > 0 || oldCount > 0) {
        setTimeout(function() {
            $('.jsFileRemove').html('');
            var htmlData = '';
            for (var i = 0; i < length; i++) {
                var file = _ths.files[i];
                var icon = getdmsFileIcon(file.name);

                images[_prefix].push(file);
                htmlData += '<span class="pip_' + _prefix + '_' + i + ' dms_' + _prefix + '">' + icon + '&nbsp;' + file.name +
                    ' <a type="button" class="delete_group" value="Delete" data-imgno="' + i +
                    '" data-prefix="' + _prefix +
                    '" data-delete="' + _deletePrefix +
                    '" download>  <i class="flaticon2-cross small"></i></a></span><br>';
            }

            $('.jsFileRemove').html(htmlData);
            // $("#" + _prefix + "_modal").find('.jsFileRemove').html(htmlData);
            // var total = parseFloat(length) + parseFloat(oldCount);

            // $('.length_' + _prefix).html(total);

        }, 1000);
    } else {
        // setTimeout(function() {
        //     $('.delete_group').attr('data-delete', _deletePrefix)
        // }, 1000);
    }
});

$(document).on('click', '.delete_group', function() {

    var imgIndex = $(this).attr('data-imgno');
    var imgPrefix = $(this).attr('data-prefix');
    var deleteName = $(this).attr('data-delete');

    var imgName = $(this).attr('data-name');

    if (imgName != undefined) {
        var _ths = $('.' + deleteName);

        var imgs = (_ths.val() != undefined) ? _ths.val().split(",") : [];
        imgs.push(imgName);
        _ths.val(imgs.join(','));

    }

    images[imgPrefix].splice(imgIndex, 1);

    $(this).parent(".pip_" + imgPrefix + '_' + imgIndex).remove();

    var dt = new DataTransfer();
    var inputData = document.getElementById(imgPrefix);
    // console.log(inputData);

    const {
        files
    } = inputData;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (imgIndex != i) {
            dt.items.add(file);
        }
    }
    inputData.files = dt.files;
    $(".jsDocument").trigger('change');

});

function getAttachmentsCount(fieldItem) {
    var selectedFiles = $("." + fieldItem).get(0).files.length;

    var numFiles = $(".count_" + fieldItem).attr('data-count_' + fieldItem);
    // var autoFetched = selectedFiles == 0 ? parseInt(numFiles) : parseInt(numFiles) + selectedFiles;
    var autoFetched = parseInt(numFiles) == 0 ? selectedFiles : parseInt(numFiles) + selectedFiles;
    var totalFiles = autoFetched;
    // console.table({
    //     selectedFiles: selectedFiles,
    //     autoFetched: autoFetched,
    //     totalFiles: totalFiles
    // });
    $('.count_' + fieldItem).text(totalFiles + ' document');
}

var repeaterImages = {};
$(document).on('click', '.jsRepeaterShowDocument', function() {
    var rRowName = $(this).attr('data-repeater-row');
    // var modalType = $(this).attr('data-modal');
    var rRepeaterItem = $(this).closest('.' + rRowName);
    var _rRDiv = rRepeaterItem.find('.jsDivClass');
    var _rRThs = rRepeaterItem.find('.jsDocument')[0];
    var _rRPrefix = $(this).attr('data-prefix');
    var _rRDeletePrefix = $(this).attr('data-delete');
    var rROldCount = rRepeaterItem.find('.length_' + _rRPrefix).attr('data-' + _rRPrefix);
    // console.log(rRepeaterItem);
    var rRowIndex = rRepeaterItem.attr('data-row-index');

    repeaterImages[_rRPrefix] = [];

    var rRLength = _rRThs.files.length;

    if (rRLength > 0 || rROldCount > 0) {
        setTimeout(function() {
            rRepeaterItem.find('.jsFileRemove').html('');
            var rRHtmlData = '';

            for (var i = 0; i < rRLength; i++) {
                var file = _rRThs.files[i];
                // console.log(file);
                var icon = getdmsFileIcon(file.name);

                repeaterImages[_rRPrefix].push(file);
                rRHtmlData += '<span class="pip_' + _rRPrefix + '_' + i + '">' + icon + '&nbsp;' + file.name +
                    ' <a type="button" class="repeater_delete_group" value="Delete" data-row-name="' + rRowName + '" data-row-index="' + rRowIndex + '" data-imgno="' + i +
                    '" data-prefix="' + _rRPrefix +
                    '" data-delete="' + _rRDeletePrefix +
                    '" download>  <i class="flaticon2-cross small"></i></a></span><br>';
            }

            // if(modalType == 'p'){
            //     rRepeaterItem.find('.jsFileRemove').html(rRHtmlData);
            // } else {
            //     $('.jsFileRemove').html(rRHtmlData);
            // }
            console.log(rRepeaterItem.find('.jsFileRemove'));

            // rRepeaterItem.find('.jsFileRemove').html(rRHtmlData);
            $('.jsFileRemove').html(rRHtmlData);

            var total = parseFloat(rRLength) + parseFloat(rROldCount);
            rRepeaterItem.find('.length_' + _rRPrefix).html(total);
        }, 1000);
    } else {
        setTimeout(function() {
            rRepeaterItem.find('.repeater_delete_group').attr('data-delete', _rRDeletePrefix);
        }, 1000);
    }
});

$(document).on('click', '.repeater_delete_group', function() {

    var rRImgIndex = $(this).attr('data-imgno');
    var rRImgPrefix = $(this).attr('data-prefix');
    var rRDeleteName = $(this).attr('data-delete');
    var rRImgName = $(this).attr('data-name');
    var rRowName = $(this).attr('data-row-name');

    var rRepeaterItem = $('.' + rRImgPrefix).closest('.' + rRowName);
    var rRowIndex = $(this).attr('data-row-index');

    // var matchingRow = rRepeaterItem.parent().find('.pbl_row[data-row-index="' + rRowIndex + '"]');
    var matchingRow = rRepeaterItem.parent().find('.' + rRowName + '[data-row-index="' + rRowIndex + '"]');
    console.log(rRowIndex);

    // var matchingRow = rRepeaterItem.find('.pbl_row[data-row-index="' + rRowIndex + '"]');


    if (rRImgName !== undefined) {
        var _rThs = matchingRow.find('.' + rRDeleteName);

        var imgs = (_rThs.val() !== undefined) ? _rThs.val().split(",") : [];
        imgs.push(rRImgName);
        _rThs.val(imgs.join(','));
    }

    repeaterImages[rRImgPrefix].splice(rRImgIndex, 1);

    $(this).parent('.pip_' + rRImgPrefix + '_' + rRImgIndex).find('[data-row-Index="' + rRowIndex + '"]').prevObject.remove();

    var dt = new DataTransfer();
    var rInputData = matchingRow.find('#' + rRImgPrefix)[0];

    const { files } = rInputData;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (rRImgIndex != i) {
            dt.items.add(file);
        }
    }

    // var remainingLength = matchingRow.find('.jsDocument')[0].files.length - 1;
    var remainingLength = matchingRow.find('.count_' + rRImgPrefix).attr('data-count_' + rRImgPrefix) - 1;
    // var autoFetchedFilesRepeater = auto.length == 0 ? 0 : parseInt(auto);

    matchingRow.find('.count_' + rRImgPrefix).text(remainingLength);
    // matchingRow.find('.count_' + rRImgPrefix).attr('data-count_' + rRImgPrefix, remainingLength);

    rInputData.files = dt.files;

    matchingRow.find(".jsDocument").trigger('change');
});

function countRepeaterDocuments(rInput, rItemRow, rAttachment) {
    var rFileInput = rInput;
    var rFileCount = rInput.get(0).files.length;

    var rCountDisplay = rFileInput.closest('.' + rItemRow).find('.count_' + rAttachment);

    var rGetFiles = rCountDisplay.attr('data-count_' + rAttachment);
    // var autoFetched = selectedFiles == 0 ? parseInt(numFiles) : parseInt(numFiles) + selectedFiles;
    var rAutoFetchedFiles = parseInt(rGetFiles) == 0 ? rFileCount : parseInt(rGetFiles) + rFileCount;
    var rTotalCount = rAutoFetchedFiles;
    console.table({
        rFileCount: rFileCount,
        rGetFiles: rGetFiles,
        rTotalCount: rTotalCount,
    });
    rCountDisplay.text(rTotalCount + ' document');
}

function getdmsFileIcon(attachment){

    fileext = attachment.substring(attachment.lastIndexOf('.')+1, attachment.length) || attachment;

    if (fileext == 'xlsx' || fileext == 'xls') {
        icon = '<img height="35" width="20" src="/media/files/exl.png" class="theme-light-show" alt="">';
    }
    else if (fileext == 'docx' || fileext == 'doc') {
        icon = '<img height="35" width="20" src="/media/files/doc.svg" class="theme-light-show" alt="">';
    }
    else if (fileext == 'pdf') {
        icon = '<img height="35" width="20" src="/media/files/pdf.svg" class="theme-light-show" alt="">';
    }
    else if (fileext == 'pptx') {
        icon = '<img height="35" weight="20" src="/media/files/ppt.png" class="theme-light-show" alt="">';
    }
    else if (fileext == 'png' || fileext == 'jpg' || fileext == 'jpeg' || fileext == 'svg' || fileext == 'webp' || fileext == 'HEIC') {
        icon = '<img height="35" weight="20" src="/media/files/png.png" class="theme-light-show" alt="">';
    }
    else {
        icon = '<img height="35" weight="20" src="/media/files/document.png" class="theme-light-show" alt="">';
    }

    return icon;
}

function getCountryCurrencySymbol(country) {
    var country_id = country.val();

    if (country_id.length === 0) {
        $('.currency_symbol').text('');
    }

    if (country_id > 0) {
        let ajaxUrl = country.attr('data-ajaxurl').replace('__id__', country_id);

        $.ajax({
            type: "GET",
            url: ajaxUrl,
            success: function(response) {
                if (response) {
                    $('.currency_symbol').text(' (' + response + ')');
                } else {
                    $('.currency_symbol').text('');
                }
            },
            error: function() {
                $('.currency_symbol').text('');
            }
        });
    }
}

const dateDifferenceInDays = (dateInitial, dateFinal) => {
    const initialDate = new Date(dateInitial);
    const finalDate = new Date(dateFinal);

    if (isNaN(initialDate.getTime()) || isNaN(finalDate.getTime())) {
        return '';
    }
    return (finalDate - initialDate) / 86_400_000 + 1;
};

function checkToDateLessThanFromDateForRepeater(from_date_input, from_date, to_date, repeater_row) {
    var rFromDateInput = from_date_input;
    var repeaterRow = rFromDateInput.closest('.' + repeater_row);
    var rFromDate = moment(repeaterRow.find('.' + from_date).val()).format('DD/MM/YYYY');
    repeaterRow.find('.' + to_date).attr('data-msg-min', "Please enter a value greater than or equal to " + rFromDate);

    // var rFromDateInput = from_date_input;
    // var repeaterRow = rFromDateInput.closest('.' + repeater_row);
    // var rFromDate = repeaterRow.find('.' + from_date).val();
    // repeaterRow.find('.' + to_date).attr('min', rFromDate).attr('data-msg-min', 'Please enter a Date greater than or equal to ' + moment(rFromDate).format('DD/MM/YYYY'));
}

// let editorInstance;
// function getCkEditor(editor_field){
//     ClassicEditor
//         .create(document.querySelector('#' + editor_field), {
//             removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
//         })
//         .then(editor => {
//             editorInstance = editor;
//         })
//         .catch(error => {
//             // console.error(error);
//         });
// }

function getCsrfToken() {
    return $('meta[name="csrf-token"]').attr('content');
}

class CkeditorFileUpload {
    constructor( loader ) {
        this.loader = loader;
        this.url = '/ckeditor-upload';
    }

    upload() {
        return this.loader.file.then(file => {
            return new Promise((resolve, reject) => {
                const data = new FormData();
                data.append('upload', file);

                $.ajax({
                    url: this.url,
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    xhr: () => {
                        const xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', evt => {
                                if (evt.lengthComputable) {
                                    this.loader.uploadTotal = evt.total;
                                    this.loader.uploaded = evt.loaded;
                                }
                            });
                        }
                        return xhr;
                    },
                    success: response => {
                        if (response && response.url) {
                            resolve({ default: response.url });
                        } else if (response && response.error) {
                            reject(response.error.message);
                        } else {
                            reject(`Couldn't upload file: ${file.name}`);
                        }
                    },
                    error: xhr => {
                        const response = xhr.responseJSON;
                        if (response && response.error) {
                            reject(response.error.message);
                        } else {
                            reject(`Couldn't upload file: ${file.name}`);
                        }
                    }
                });
            });
        });
    }

}
function CkeditorFileUploadPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        return new CkeditorFileUpload( loader );
    };
}
let editorInstance;
function getCkEditor(editor_field, imageUploaderPlugin){
    const editorConfig = {
        // removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'ImageCaption', 'ImageStyle', 'MediaEmbed', 'Image'],
        extraPlugins: []
    };
    if(imageUploaderPlugin){
        editorConfig.extraPlugins.push(CkeditorFileUploadPlugin);
        editorConfig.removePlugins.pop(Image);
    }
    ClassicEditor
        .create(document.querySelector('#' + editor_field), editorConfig)
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            // console.error(error);
        });
}

function check_ck_editor(check_field) {
    if (editorInstance) {
        document.querySelector('#' + check_field).value = editorInstance.getData();

        if (editorInstance.getData().trim() === '') {
            $("#" + check_field + "-error").html('This field is required.');
            return false;
        } else {
            $("#" + check_field + "-error").empty();
            return true;
        }
    }
    return false;
}

function checkPinCodeValidation(pincode_field, required_class, country_name) {
    const pincodeField = $('.' + pincode_field);

    pincodeField.rules('remove', 'PinCode');
    pincodeField.rules('remove', 'PinCodeV2');

    if (country_name.toLowerCase() === 'india') {
        pincodeField.rules('add', {
            PinCode: true,
        });
        $('.' + required_class).addClass('required');
        $('.jsRemoveAsterisk').removeClass('d-none');
    } else {
        pincodeField.rules('add', {
            PinCodeV2: true,
        });
        $('.' + required_class).removeClass('required');
        $('.jsRemoveAsterisk').addClass('d-none');
    }
}

    //Loader End
    function addLoadSpiner(el) {
        //debugger;
        if (el.length > 0) {
            if ($("#img_" + el[0].id).length > 0) {
                $("#img_" + el[0].id).css('display', 'block');
            }               
            else {
                /*var img = $('<img class="ddloading">');
                img.attr('id', "img_" + el[0].id);
                img.attr('src', 'storage/default/orange_circles.gif');
                img.css({ 'display': 'block', 'width': '30px', 'height': '30px', 'z-index': '100', 'float': 'right' ,'margin-right': '22px','margin-top': '10px'});
                img.prependTo(el[0].nextElementSibling);*/
                var img = $('<span class="ddloading"><i class="fas fa-spinner fa-pulse" style="margin-top: 10px; color: #3c3b90"></i>');
                img.attr('id', "img_" + el[0].id);
                //img.text('<i class="fas fa-spinner fa-pulse"></i>');
                //img.attr('src', 'storage/default/orange_circles.gif');
                img.css({ 'display': 'block', 'width': '22px', 'height': '0px', 'z-index': '999', 'float': 'right' ,'margin-right': '22px'});
                //$(".ddloading").html('');
                img.prependTo(el[0].nextElementSibling);
            }
            el.prop("disabled", true);               
        }
    }

    //Loader End
    function hideLoadSpinner(el) {
        if (el.length > 0) {
            if ($("#img_" + el[0].id).length > 0) {
                setTimeout(function () {
                    $("#img_" + el[0].id).css('display', 'none');
                    el.prop("disabled", false);
                }, 500);                    
            }
        }
    }

    
    function setFilterData(fieldData){

        $('.jsFilterData').html('');
        var htmlData = '';
        $.each(fieldData, function(i, fieldName){
            
            var _field = $('.'+fieldName);
            var _fieldVal = ''
            if(_field.is("select") && _field.val() != '') {
                _fieldVal = $( "option:selected", _field ).text();
            }else{
                _fieldVal = _field.val();    
            }
            
            if(_fieldVal !=''){
                
                htmlData += '<span class="btn btn-light-dark font-weight-bold mr-2 remove-filter jsRemoveFilter" data-field-name="'+fieldName+'"> <i class="ki ki-bold-close icon-sm"></i> '+_fieldVal+'</span>';
            }
        });  
        $('.jsFilterData').append(htmlData);
    }

    $(document).on('click', '.jsRemoveFilter', function(){

        var fieldName = $(this).data('field-name');
        var _field = $('.'+fieldName);        
        if(_field.is("select")) {
            _field.val('').trigger('change');
        }else{
            _field.val('');    
        }
        setTimeout(function(){
            $('.jsBtnSearch').click();
        },200);
    });

    var openExchangeAppId = '54fd73584ac6436fb9fa0e3f2f42cf80';
    var latestUrl = 'https://openexchangerates.org/api/latest.json?app_id='+openExchangeAppId;
    var USDRate = 0;
    var EURRate = 0;
    var GBPRate = 0;
    var CADRate = 0;
    var curr_rates = [{'USD':'0','EUR':'0','GBP':'0','CAD':'0','ZAR' :'0','AUD':'0','AED':'0'}];

    $(document).on('change','#currency',function(){
        var currency = jQuery(this).val();
        if (currency) {
            addLoadSpiner(jQuery('#currency'));
            if (currency == "INR") {
                var INRRate = 1;
                currencyRate = jQuery("input[name='currency_rate']");
                currencyRate.val(INRRate.toFixed(4)).trigger('change');
                hideLoadSpinner(jQuery('#currency'));
            } else {
                if (!USDRate) {
                    $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
                        if (options.crossDomain) {
                            delete options.headers['X-CSRF-TOKEN'];
                        }   
                    });
                    $.get(latestUrl, function(data, status){
                        USDRate = data.rates.INR;
                        EUR_USD = 1 / data.rates.EUR;
                        EURRate = EUR_USD * data.rates.INR;
                        GBP_USD = 1 / data.rates.GBP;
                        GBPRate = GBP_USD * data.rates.INR;
                        // Canadian Dollar
                        CAD_USD = 1 / data.rates.CAD;
                        CADRate = CAD_USD * data.rates.INR;

                        ZAR_USD = 1 / data.rates.ZAR;
                        ZARRate = ZAR_USD * data.rates.INR;
                        
                        AUD_USD = 1 / data.rates.AUD;
                        AUDRate = AUD_USD * data.rates.INR;

                        AED_USD = 1 / data.rates.AED;
                        AEDRate = AED_USD * data.rates.INR;

                        // Round to 4 Precision
                        curr_rates['USD'] = USDRate = USDRate.toFixed(4);
                        curr_rates['EUR'] = EURRate = EURRate.toFixed(4);
                        curr_rates['GBP'] = GBPRate = GBPRate.toFixed(4);
                        curr_rates['CAD'] = CADRate = CADRate.toFixed(4);
                        curr_rates['ZAR'] = ZARRate = ZARRate.toFixed(4);
                        curr_rates['AUD'] = AUDRate = AUDRate.toFixed(4);
                        curr_rates['AED'] = AEDRate = AEDRate.toFixed(4);
                        // CAD: 1.268915

                        currencyRate = jQuery("input[name='currency_rate']");
                        currencyRate.val(curr_rates[currency]).trigger('change');
                        hideLoadSpinner(jQuery('#currency'));
                    });
                }
                setTimeout(function() {
                    currencyRate = jQuery("input[name='currency_rate']");
                    currencyRate.val(curr_rates[currency]).trigger('change');
                    hideLoadSpinner(jQuery('#currency'));
                }, 1000);
            }
        }
    });

    // $('.custom-select-sm').change();

    //Due Date
    function dateFormate(date) {
        let year = date.getFullYear();
        let month = (1 + date.getMonth()).toString().padStart(2, '0');
        let day = date.getDate().toString().padStart(2, '0');
        return year + '-' + month + '-' + day;
    }   

    // Header Sticky Report
    var isSticky = document.querySelector('[data-module="sticky-table"]');
    if(isSticky)
    {

        setTimeout(function() {
            let xscroller = document.querySelector('.dataTables_scrollBody');
            let head = document.querySelector('.dataTables_scrollHead');
            if (head) {
                head['style'].overflow = '';
                xscroller.addEventListener('scroll', function(e) {
                    head['style'].left = '-' + e.target['scrollLeft'] + 'px';
                });
            }
        }, 1000);

        var el = document.querySelector('[data-module="sticky-table"]');
        var scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
        var thead = el.querySelector('thead');
        var offset = el.getBoundingClientRect();

        // Make sure you throttle/debounce this
        window.addEventListener('scroll', function (event) {
            var rect = el.getBoundingClientRect();
            scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
            if (rect.top < thead.offsetHeight) {
                thead.style.width = rect.width + 'px';
                thead.classList.add('thead--is-fixed');
            } else {
                thead.classList.remove('thead--is-fixed');
            }
        });
    }