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

// Pré-remplissage INPN (TAXREF local) dans les formulaires admin :
// autocomplétion du nom latin + bouton "Pré-remplir via l'INPN"
document.addEventListener('DOMContentLoaded', () => {
    const latin = document.getElementById('namelatin');
    const datalist = document.getElementById('taxref-suggest');
    const btn = document.getElementById('inpnFill');
    const status = document.getElementById('inpnStatus');
    if (!latin || !btn) return;

    const nameInput = document.getElementById('name');
    const familleInput = document.getElementById('famille');
    const lienInput = document.getElementById('lien-inpn');
    const repTextarea = document.getElementById('repartition');
    const repPreset = document.getElementById('repartitionPreset');
    const groupe = btn.dataset.groupe || '';
    const endpoint = '../admin/inpn_lookup.php';

    async function lookup(q) {
        if (!q || q.trim().length < 2) return [];
        try {
            const res = await fetch(endpoint + '?q=' + encodeURIComponent(q) + (groupe ? '&groupe=' + groupe : ''));
            if (!res.ok) return [];
            const data = await res.json();
            return data.results || [];
        } catch (e) {
            return [];
        }
    }

    function setStatus(msg, ok) {
        if (status) {
            status.textContent = msg;
            status.classList.toggle('error', !ok);
        }
    }

    // Remplit les champs vides à partir d'une fiche TAXREF
    function applyResult(r) {
        if (nameInput && !nameInput.value && r.nom_vern) nameInput.value = r.nom_vern;
        if (familleInput && !familleInput.value && r.famille) familleInput.value = r.famille;
        if (latin && !latin.value && r.nom) latin.value = r.nom;
        if (lienInput && !lienInput.value && r.url_inpn) lienInput.value = r.url_inpn;
        if (repTextarea && repPreset && !repTextarea.value && r.fr === 'P') {
            const opt = Array.from(repPreset.options).find(o => o.value.includes('tout le territoire métropolitain.'));
            if (opt) {
                repPreset.value = opt.value;
                repTextarea.value = opt.value;
            }
        }
        setStatus('INPN : ' + r.nom + (r.nom_vern ? ' — ' + r.nom_vern : '') + ' (' + r.famille + ', cd_nom ' + r.cd_ref + ')', true);
    }

    // Autocomplétion du nom latin (datalist alimenté par TAXREF)
    let debounce = null;
    if (datalist) {
        latin.addEventListener('input', () => {
            clearTimeout(debounce);
            debounce = setTimeout(async () => {
                const results = await lookup(latin.value);
                datalist.innerHTML = '';
                for (const r of results) {
                    const opt = document.createElement('option');
                    opt.value = r.nom;
                    opt.label = (r.nom_vern ? r.nom_vern + ' — ' : '') + r.famille;
                    datalist.appendChild(opt);
                }
            }, 250);
        });
        latin.addEventListener('change', async () => {
            const results = await lookup(latin.value);
            const exact = results.find(r => r.nom.toLowerCase() === latin.value.trim().toLowerCase());
            if (exact) applyResult(exact);
        });
    }

    // Bouton : pré-remplit depuis le nom latin, ou depuis le cd_nom du lien INPN
    btn.addEventListener('click', async () => {
        const q = latin.value.trim() || (lienInput ? lienInput.value.trim() : '');
        setStatus('Recherche dans le référentiel INPN…', true);
        const results = await lookup(q);
        if (results.length === 0) {
            setStatus('Aucun résultat INPN pour « ' + q + ' » — vérifiez le nom latin.', false);
            return;
        }
        applyResult(results[0]);
    });
});
