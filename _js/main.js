history.scrollRestoration = "manual";

function filterSpecies() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const items = document.getElementsByClassName('species-item');

    for (let i = 0; i < items.length; i++) {
        const commonName = items[i].querySelector('.common-name').textContent.toLowerCase();
        const scientificName = items[i].querySelector('.scientific-name').textContent.toLowerCase();

        if (commonName.includes(filter) || scientificName.includes(filter)) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}

function toggleSpecies(element) {
    const parent = element.parentElement;
    const willOpen = !parent.classList.contains('open');
    element.classList.toggle('active');
    parent.classList.toggle('open');

    if (willOpen) {
        const img = parent.querySelector('.detail-img[data-src]');
        if (img && !img.getAttribute('src')) {
            img.src = img.dataset.src;
        }
    }
}

$(document).ready(function () {
    var lightbox = $('.details-inner a').simpleLightbox({
        captions: true,
        showCounter: false,
        nav: false,
        enableKeyboard: false,
        scrollZoom: false
    });
});
