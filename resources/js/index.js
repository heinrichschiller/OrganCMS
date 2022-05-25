import 'bootstrap'
import SimpleLightBox from 'simplelightbox'
import tinymce from 'tinymce';
// import DonationForm from './DonationForm';

let gallery = new SimpleLightBox('.gallery a')
gallery.on('show.simplelightbox', function() {
    
});

// DonationForm.run()

tinymce.init({
    selector: 'textarea#default-editor',
    menubar: false,
    toolbar: 'undo redo | bold italic underline strikethrough | fontsize  fontname | alignleft aligncenter alignright alignjustify'
})

let clickableRows = document.querySelectorAll('.clickable-row')

let i = 0
clickableRows.forEach(elm => {
    clickableRows[i].addEventListener('click', () => {
        let href = elm.getAttribute('data-href')

        if (href) {
            window.location = href
        }
    })
    i++
})
