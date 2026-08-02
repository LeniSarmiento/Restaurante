const menuToggle = document.querySelector('[data-menu-toggle]');
const mainNav = document.querySelector('[data-main-nav]');

if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', () => mainNav.classList.toggle('open'));
    mainNav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => mainNav.classList.remove('open'));
    });
}

const todayInput = document.querySelector('[data-today]');
if (todayInput) {
    todayInput.min = new Date().toISOString().split('T')[0];
}

const slider = document.querySelector('[data-menu-slider]');
const prevBtn = document.querySelector('[data-menu-prev]');
const nextBtn = document.querySelector('[data-menu-next]');
const thumbButtons = document.querySelectorAll('[data-menu-thumb]');
const menuPages = document.querySelectorAll('[data-menu-page]');

function getCurrentPageIndex() {
    if (!slider || !menuPages.length) return 0;
    const currentTop = slider.scrollTop;
    let closestIndex = 0;
    let closestDistance = Infinity;

    menuPages.forEach((page, index) => {
        const distance = Math.abs(page.offsetTop - slider.offsetTop - currentTop);
        if (distance < closestDistance) {
            closestDistance = distance;
            closestIndex = index;
        }
    });

    return closestIndex;
}

function scrollToPage(index) {
    if (!slider || !menuPages.length) return;
    const safeIndex = Math.max(0, Math.min(index, menuPages.length - 1));
    const page = menuPages[safeIndex];
    slider.scrollTo({ top: page.offsetTop - slider.offsetTop, behavior: 'smooth' });
}

function setActiveThumb() {
    if (!slider || !thumbButtons.length) return;
    const index = getCurrentPageIndex();
    thumbButtons.forEach((btn, i) => btn.classList.toggle('active', i === index));
}

if (slider) {
    setActiveThumb();

    prevBtn?.addEventListener('click', () => {
        scrollToPage(getCurrentPageIndex() - 1);
    });

    nextBtn?.addEventListener('click', () => {
        scrollToPage(getCurrentPageIndex() + 1);
    });

    thumbButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const index = Number(btn.dataset.menuThumb || 0);
            scrollToPage(index);
        });
    });

    slider.addEventListener('scroll', () => window.requestAnimationFrame(setActiveThumb));
}

const revealElements = document.querySelectorAll('.reveal');
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

revealElements.forEach((element) => revealObserver.observe(element));

// ==========================================
// FILTRADO INTERACTIVO DE PLATOS (Restaurante)
// ==========================================
function filterDishes() {
    const query = document.getElementById('dish-search-input').value.toLowerCase();
    const dishes = document.querySelectorAll('.dish-item');
    let foundAny = false;

    dishes.forEach(dish => {
        const name = dish.querySelector('.dish-name').textContent.toLowerCase();
        const desc = dish.querySelector('.dish-desc').textContent.toLowerCase();
        const tag = dish.querySelector('.dish-tag').textContent.toLowerCase();

        if (name.includes(query) || desc.includes(query) || tag.includes(query)) {
            dish.style.display = 'flex';
            foundAny = true;
        } else {
            dish.style.display = 'none';
        }
    });

    const noFoundMessage = document.getElementById('no-dish-found');
    if (noFoundMessage) {
        noFoundMessage.style.display = foundAny ? 'none' : 'block';
    }
}
