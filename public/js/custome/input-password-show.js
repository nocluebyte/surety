$('.js-show-password').click(function(){
    
    $(this).closest('.input-group').find('.js-show-password-input').attr('type', function(index, currentType) {
        return currentType === 'password' ? 'text' : 'password';
    });
    $(this).closest('.input-group').find('.js-show-password-icon').toggleClass('fa-eye fa-eye-slash');
});