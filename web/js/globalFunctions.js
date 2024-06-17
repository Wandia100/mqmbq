function toastErrorNotification(message){
    toastr.error(message,'Error', {
        "newestOnTop": true,
        "progressBar": true,
        "showEasing": "swing",
    });
}

function toastSuccessNotification(message){
    toastr.success(message,'Success', {
        "newestOnTop": true,
        "progressBar": true,
        "showEasing": "swing",
    });
}

function toastInfoNotification(message){
    toastr.info(message,'Info', {
        "newestOnTop": true,
        "progressBar": true,
        "showEasing": "swing",
    });
}

function getLoginScenario(scenario) {
    if (scenario == 'db') {
        // $('#user-password_hash').val('Hidden').blur();
        // $('#user-auth_key').val('Hidden').blur();
    
        // $('#user-password_hash').click(function() {
        //     $('#user-password_hash').val('');
        // });
        // $('#user-auth_key').click(function() {
        //     $('#user-auth_key').val('');
        // });
        // $('#user-password_hash').hover(function() {
        //     $('#user-password_hash').val('Hidden').blur();
        // });
        // $('#user-auth_key').hover(function() {
        //     $('#user-auth_key').val('Hidden').blur();
        // });
    }
}
