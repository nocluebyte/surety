<script>
    $(document).ready(function(){
        select2Init();
    });

    let select2Init = function(){
        $('.document_type,.file_source').select2({
            allowClear:true,
            placeholder:'Select',
            dropdownParent:'#dmsModal'
        });
    }
</script>