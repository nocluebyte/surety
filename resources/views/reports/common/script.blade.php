<script>
    $(document).ready(function(){
        toggleCheckbox();
    });

    let toggleCheckbox = function(){
    
        $('.checkRowAll').click(function(){
            let selectAll = $('.checkRowAll').is(':checked');
            $('.checkRow').attr('checked',selectAll);
        });

        $(document).on('change','.checkRow,.checkRowAll',function(){
            let anyCheckboxChecked =  $('.checkRow').is(':checked');  
            if (anyCheckboxChecked) {
                $('.submit').attr('disabled',false);
            }else{
                $('.submit').attr('disabled',true);
            }
        })

        jQuery(".btn_reset").on('click', function(e) {
            window.location.reload();
        });
    }
</script>