$('#auth-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/login',
        method: 'POST',
        data: $('#auth-form').serialize(),
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                window.location.replace('/diary');
            }
        }
    });
});

$('#register-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/register',
        method: 'POST',
        data: $('#register-form').serialize(),
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                $('#register-form')[0].reset();
                showPopup('success', 'Registration completed!')
            }
        }
    });
});

$('#compose-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/compose',
        method: 'POST',
        data: $('#compose-form').serialize(),
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                window.location.reload();
            }
        }
    });
});

$('#edit-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/edit',
        method: 'POST',
        data: $('#edit-form').serialize(),
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                window.location.reload();
            }
        }
    });
});

$('#change_password_form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: '/change_password',
        method: 'POST',
        data: $('#change_password_form').serialize(),
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                showPopup('success', 'Password successfully changed!');
                $('#change_password_form')[0].reset();
            }
        }
    });
});
