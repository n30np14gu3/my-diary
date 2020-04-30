function showModal(modal_id) {
    $('#' + modal_id).modal('show');
}

function showPopup(type, message) {
    $('body')
        .toast({
            class: type,
            showIcon: false,
            message: message
        });
}

function deleteNote(note_id) {
    if(!confirm('Are you sure?'))
        return;

    $.ajax({
        method: 'POST',
        url: '/delete',
        data: {'note_id': note_id},
        success: function (data) {
            if(data.status !== 'OK'){
                showPopup('error', data.message);
            }
            else{
                window.location.replace('/diary');
            }
        }
    })
}
