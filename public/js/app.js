tinymce.init({
    selector: 'textarea.wysiwyg'
});
tinymce.init({
    selector: 'textarea.wysiwyg-simple',
    plugins: [
        'lists charmap',
        'code fullscreen',
        'insertdatetime contextmenu paste code'
    ],
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist insertdatetime charmap | code',
    menubar: false,
});