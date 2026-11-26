// Filtre de recherche dans la liste des espèces
function filterSpecies() {
    const input = document.getElementById('searchInput');
    if (!input) return;
    const filter = input.value.toLowerCase().trim();
    const items = document.querySelectorAll('.species-item');
    let visible = 0;

    items.forEach((item) => {
        const common = item.querySelector('.common-name')?.textContent.toLowerCase() || '';
        const scientific = item.querySelector('.scientific-name')?.textContent.toLowerCase() || '';
        const show = filter === '' || common.includes(filter) || scientific.includes(filter);
        item.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    const noResult = document.getElementById('noResult');
    if (noResult) noResult.hidden = visible !== 0;
}

// Accordéon : ouvre/ferme le détail d'une espèce, charge l'image en lazy
function toggleSpecies(btn) {
    const item = btn.closest('.species-item');
    const willOpen = !item.classList.contains('open');

    // Ferme les autres
    document.querySelectorAll('.species-item.open').forEach((other) => {
        if (other !== item) {
            other.classList.remove('open');
            other.querySelector('.species-row')?.classList.remove('active');
            other.querySelector('.species-row')?.setAttribute('aria-expanded', 'false');
        }
    });

    item.classList.toggle('open', willOpen);
    btn.classList.toggle('active', willOpen);
    btn.setAttribute('aria-expanded', String(willOpen));

    if (willOpen) {
        const img = item.querySelector('.detail-img[data-src]');
        if (img && !img.getAttribute('src')) {
            img.src = img.dataset.src;
        }
    }
}

// Lightbox vanilla : plein écran sur clic d'une image de détail
(function initLightbox() {
    const overlay = document.createElement('div');
    overlay.className = 'lightbox-overlay';
    overlay.innerHTML = '<button class="lightbox-close" aria-label="Fermer">&times;</button><img class="lightbox-img" alt=""><p class="lightbox-caption"></p>';
    document.body.appendChild(overlay);

    const imgEl = overlay.querySelector('.lightbox-img');
    const captionEl = overlay.querySelector('.lightbox-caption');

    function open(link) {
        imgEl.src = link.getAttribute('href');
        imgEl.alt = link.querySelector('img')?.alt || '';
        captionEl.textContent = link.dataset.caption || '';
        overlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }

    function close() {
        overlay.classList.remove('visible');
        imgEl.src = '';
        document.body.style.overflow = '';
    }

    document.addEventListener('click', (e) => {
        const link = e.target.closest('.detail-link');
        if (link) {
            e.preventDefault();
            open(link);
            return;
        }
        if (e.target === overlay || e.target.closest('.lightbox-close')) {
            close();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('visible')) close();
    });
})();

// Préréglage de la répartition dans les formulaires admin :
// le select pré-remplit le textarea (qui reste éditable librement)
document.addEventListener('DOMContentLoaded', () => {
    const preset = document.getElementById('repartitionPreset');
    const textarea = document.getElementById('repartition');
    if (preset && textarea) {
        preset.addEventListener('change', () => {
            const v = preset.value;
            if (v && v !== '__autre__') {
                textarea.value = v;
            }
        });
    }
});
