$(document).ready(function(){
    $('.message #login').click(function(){ // click on "Login"
        $('#login-form').show("slow");
        $('#register-form').hide("slow");
        $('#forgot-form').hide("slow");
        $('.error-message').text("");
        $('#login-form #login-email').focus();
    })
    $('.message #register').click(function(){ // click on "Create an account"
        $('#login-form').hide("slow");
        $('#register-form').show("slow");
        $('#forgot-form').hide("slow");
        $('.error-message').text("");
        $('#register-form #register-email').focus();
    })
    $('.message #forgot').click(function(){ // click on "Reset it"
        $('#login-form').hide("slow");
        $('#register-form').hide("slow");
        $('#forgot-form').show("slow");
        $('.error-message').text("");
        $('#forgot-form #forgot-email').focus();
    })
    $('#register-submit').click(function(){
        $('#register-form').submit();
    })
    $('#login-submit').click(function(){
        $('#login-form').submit();
    })
    $('#forgot-submit').click(function(){
        $('#forgot-form').submit();
    })
})
