/**
 * Missing photos never show alt text or the browser's broken-image icon:
 * inside copy (articles, descriptions) the image is removed; in a gallery frame
 * or card it is hidden so only the neutral frame remains.
 */
const markBroken = (img) => {
    if (img.dataset.broken) return;
    img.dataset.broken = '1';

    if (img.closest('.rich-text')) {
        img.remove();
        return;
    }

    img.classList.add('is-broken');
    img.parentElement?.classList.add('has-broken-image');
};

document.addEventListener('error', (event) => {
    if (event.target instanceof HTMLImageElement) markBroken(event.target);
}, true);

// Images that already failed before this module ran.
document.querySelectorAll('img').forEach((img) => {
    if (img.complete && img.getAttribute('src') && img.naturalWidth === 0) markBroken(img);
});
