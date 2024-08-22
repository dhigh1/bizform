<script type="text/javascript">
if($("#loginForm").length > 0) {
    login();
}

function login(){
    $('#loginForm').validate({   
        errorClass: 'error',
        validClass: 'valid',
        rules: {
            uid: {required: true},
            pwd: {required: true}
        },
        messages:{
            uid: { required: "Please enter your username or email address"},
            pwd: { required: "Please enter your password" }
        },   
        errorPlacement: function ( error, element ) {
            if(element.parent().hasClass('input-group')){
              error.insertAfter( element.parent() );
            }else{
                error.insertAfter( element );
            }
        },
        submitHandler: function(){
            $('#loginForm').find('.div_res').html('');
            var formdata = new FormData($('#loginForm')[0]);
            $["ajax"]({
               url: urljs+'login/authentication',
               type: "POST",
               dataType: "json",
               data: formdata,
               contentType: false,
               cache: false,
               processData: false,
               beforeSend: function() {
                   button_load('#loginForm','Logging in...','');
               },
               success: function(data) {
                    end_button_load('#loginForm','');
                    if(data.status=='success' && data.urlredirect!=''){
                        successResult('#loginForm',data.message,false);
                        $('#loginForm').find('button[type=submit]').attr('disabled','true');
                        window.location=data.urlredirect;
                    }else{
                        failureResult('#loginForm',data.message,false);
                    }
               },
               error: function() {}
           })
        }
    });
}


</script>