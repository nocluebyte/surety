@push('scripts')

<script type="text/javascript">
    @if (!empty($userPermissions))
        var permissionArr = @php echo json_encode($userPermissions) @endphp;
    @else
        var permissionArr = [];
    @endif
    @if (!empty($groupPermissions))
        var groupPermissionArr = @php echo json_encode($groupPermissions) @endphp;
    @else
        var groupPermissionArr = [];
    @endif
    $(document).ready(function() {
        initValidation();
        initLeadRepeater();

        jQuery.validator.addMethod("require_from_group", function(value, element, options) {
            var isvalid = false;
            if($('#is_ip_base').is(':checked')){
                $(".loginip").each(function() {
                    if($(this).val() != '')
                    {
                        //$(this).addClass('IP4Checker');
                        isvalid = true;
                    }                    
                });                
            }
            return isvalid;
        }, "Please fill out at least one of these fields.");

        $.validator.addMethod('IP4Checker', function(value) {
            if(value!=''){
                return value.match(/^(?=.*?[A-Z])(?=.*?[a-z])(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/);
            }
        }, 'Invalid IP address format');

        // "filone" is the class we will use for the input elements at this example
        jQuery.validator.addClassRules("loginip", {
            require_from_group: 'login_ip'
        });

        $(document).on('change', '.cls-role', function() {
            var roleId = $(this).val();
            if (roleId) {
                $.ajax({
                    url: "{{route('getRolePermissions')}}",
                    type: "GET",
                    data : {role_id : roleId},
                    success: function(response) {
                        if (response.status == "success") {
                            $(".cls-treeview").kendoTreeView({
                                checkboxes: {
                                    checkChildren: true,
                                },
                                check: onCheck,
                                dataSource: response.data.rolePermissionData
                            });
                            // $(".cls-treeview").find('.k-checkbox:indeterminate').attr("disabled", "disabled");
                            $(".cls-treeview").find('.k-checkbox:checked').attr("disabled", "disabled");
                            onCheck();
                        }
                    }
                });
            }
        });

        if (typeof $('#userId').val() != "undefined" && $('#userId').val() != "") {
            var permissions = $.map(permissionArr, function(value, index) {
                if(value.text == 'Purchase'){
                    $(value.items).each(function(i,item){
                        if(item.text == 'purchase_order'){
                            $(item.items).each(function(i,row){
                                if(row.text == 'edit'){
                                    row.text = 'Edit / Edit Status';
                                }
                            });
                            
                        }                        
                    });
                }
                return [value];
            });            
            // if (permissionArr.length > 0) {
                $(".cls-treeview").kendoTreeView({
                    checkboxes: {
                        checkChildren: true
                    },
                    check: onCheck,
                    dataSource: permissions
                });
                onCheck();
            // }
        }
    });

    var initValidation = function() {
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });

        let is_edit = $('#userId').val() ? false : true;

        $('#userForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules:{
                password: {
                    required: is_edit,
                    pwcheck: is_edit,
                    minlength: 8
                },
                password_confirmation: {
                    equalTo: '#password'
                },
                overall_cap: {
                    required: true,
                    min: ()=> parseInt($('#individual_cap').val())
                },
                group_cap: {
                    required: true,
                    min:()=> parseInt($('#overall_cap').val())
                },
            },
            messages: {
                password: {
                    pwcheck: 'Password must have (1) atleast 8 characters (2) atleast 1 uppercase (3) atleast 1 lowercase (4) atleast 1 number (5) atleast 1 special char',
                    minlength: "Please enter atleast 8 digit."
                },
                password_confirmation: {
                    required: "Confirm password does not match with password",
                    minlength: "Confirm Password must be at least 8 characters long.",
                    equalTo: "Confirm password does not match with password"
                },
                overall_cap: {
                    min: "Please enter a value greater than or equal to Individual Cap.",
                },
                group_cap: {
                    min: "Please enter a value greater than or equal to Overall Cap.",
                },
            },
            errorPlacement: function(error, element) {

                if(element.parent().hasClass('input-group')) 
                {
                    error.appendTo(element.parent().parent()).addClass('text-danger');
                }
                else{
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            },
            submitHandler: function(e) {
                $('form *').prop('disabled', false);
                $('#btn_loader').addClass('spinner spinner-white spinner-left');
                $('#btn_loader').prop('disabled', true);
                return true;
            }
        });

        $('#location_id').select2({allowClear:true});
        $('#roles_id').select2({allowClear:true});
        $('#emp_id').select2({allowClear:true});
        $('#process').select2({
            'placeholder' :'Select Process'
        });
        //$(".employeeData").show();
        @php if(!isset($users)) { @endphp
        $("#emp_id").addClass('required');
        @php } @endphp
        //$(".ipRepeaterData").hide();

        $(".emp_type").change(function(e){
            var emp_type = $(this).val();
            if(emp_type == 'employee'){
                $(".employeeData").show();
                $("#emp_id").addClass('required');
            } else {
                $(".employeeData").hide(); 
                $("#emp_id").removeClass('required');
            }
        });

        $('#emp_id').change(function(){
            var emp_id = $(this).val();
            if(emp_id){
                $.ajax({
                    url: "{{route('getEmployeeData')}}",
                    data : {emp_id : emp_id}

                }).done(function(response) {

                    $('#first_name').val(response.first_name);
                    $('#middle_name').val(response.middle_name);
                    $('#last_name').val(response.last_name);
                    // $('#email').val(response.employee_address.email);
                    console.log(response);
                });
            }
        });

        $('.is_ip_base').on('click', function () {
            if($(this).is(':checked')){
                $(".ipRepeaterData").show();
                //$('.ipRepeaterData').find('#login_ip1').addClass('required')
            } else {
                $(".ipRepeaterData").hide();
                //$('.ipRepeaterData').find('#login_ip1').removeClass('required')
            }
        });
    };

    var initLeadRepeater = function() {
        $('#ip_repeater').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                $(this).find('.list-no').text($(this).index() + 1 + ' .');
                var num_index = $(this).index()+1;
                $(this).find('.loginip').prop('id','login_ip'+num_index);
                $(this).slideDown();                
            },

            hide: function(deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });

    };

    // function that gathers IDs of checked nodes
    function checkedNodeIds(nodes, checkedNodes) {
        var treeview = $(".cls-treeview").data("kendoTreeView");
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].checked) {
                if ($.inArray(nodes[i].id, groupPermissionArr) != -1) {
                    var node = treeview.findByUid(nodes[i].uid);
                    node.find('.k-checkbox').attr("disabled", "disabled");
                }
                var node1 = treeview.findByUid(nodes[i].uid);
                if (!node1.find('.k-checkbox').prop('disabled')) {
                    checkedNodes.push(nodes[i].id);
                }
            }
            if (nodes[i].hasChildren) {
                checkedNodeIds(nodes[i].children.view(), checkedNodes);
            }
        }
    }

    // show checked node IDs on datasource change
    function onCheck() {
        var checkedNodes = [],
            treeView = $(".cls-treeview").data("kendoTreeView"),
            message;
       
        checkedNodeIds(treeView.dataSource.view(), checkedNodes);
        $('#user_permission').val(checkedNodes.join(","));

        // if (checkedNodes.length > 0) {
        //     message = "IDs of checked nodes: " + checkedNodes.join(",");
        // } else {
        //     message = "No nodes checked.";
        // }

        // $("#result").html(message);
    }

    $(".validate_password").passwordRequirements({
        numCharacters: 8,
        useLowercase:true,
        useUppercase:true,
        useNumbers:true,
        useSpecial:true
    });
</script>

@endpush