/**
 * Lufly Architectural Ceramics - Product Gallery Switcher
 */

document.addEventListener('DOMContentLoaded', () => {
    const mainImg = document.getElementById('product-main-image');
    const thumbBtns = document.querySelectorAll('.gallery-thumb-btn');

    if (!mainImg || thumbBtns.length === 0) return;

    thumbBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetSrc = btn.getAttribute('data-img-src');
            if (!targetSrc || mainImg.src === targetSrc) return;

            // Highlight active thumb
            thumbBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Fade transition
            mainImg.style.opacity = '0.4';
            mainImg.style.transform = 'scale(0.98)';

            setTimeout(() => {
                mainImg.src = targetSrc;
                mainImg.style.opacity = '1';
                mainImg.style.transform = 'scale(1)';
            }, 120);
        });
    });
});
