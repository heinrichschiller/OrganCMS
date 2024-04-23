import tinymce from 'tinymce'

tinymce.init({
    selector: 'textarea#default-editor',
    plugins: 'image media link',
    menubar: false,
    toolbar: 'undo redo | bold italic underline strikethrough | fontsize  fontname | alignleft aligncenter alignright alignjustify | link | image media',
    image_advtab: true,
    image_class_list: [
        { title: 'None', value: '' },
        { title: 'Default', value: 'img-fluid' }
    ]
})

tinymce.init({
    selector: 'textarea#intro-editor',
    menubar: false,
    toolbar: 'undo redo | bold italic strikethrough | alignleft aligncenter alignright alignjustify',
    height: "200"
})