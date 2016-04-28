// The Upload Button for the Brochure Widget

jQuery('.upload-file-button').live('click', function(){

    var clicked = jQuery(this);

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
        title: 'Choose a File',
        button: { text: 'Select File' },
        multiple: false
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {

        // Get the url of the selected object and add to the input field
        attachment = file_frame.state().get('selection').first().toJSON();
        clicked.closest('p').find('.upload-file-url').val(attachment.url);
    });

    // Open the modal
    file_frame.open();
});