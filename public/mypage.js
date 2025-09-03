function checkAllItems() {
    $('.item_list_delete').prop('checked', true);
}

function uploadUserImage() {
    $('#user_image_file_name').trigger('click');
}

function deleteUserImage() {
    $('#userImageDelForm').submit();
}

$(document).ready(function () {
    $('#message-content').on('change', function () {
        if ($(this).val().length > 0) {
            $('#send-button').attr('disabled', false);
        } else {
            $('#send-button').attr('disabled', true);
        }
    });

    $('#user_image_file_name').change(function(e) {
        $('#userImageFileForm').submit();
    });
});