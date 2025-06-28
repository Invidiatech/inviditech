tinymce.init({
        selector: '#editor',
        height: 150,  // Adjust height as needed
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview anchor',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | outdent indent | link image',
        content_css: 'tinyMCE/skins/ui/oxide/content.min.css',
    });
