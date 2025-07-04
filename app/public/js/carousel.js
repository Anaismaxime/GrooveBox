
console.log('carousel.js chargé ✅');
    const container = document.querySelector('.carousel-container');
    const carousel = container.querySelector('.carousel');
    const slides = carousel.querySelectorAll('.slide');

    let index = 0;

    function scrollToSlide(i) {
        const slideWidth = slides[i].offsetWidth;
        container.scrollTo({
            left: slideWidth * i,
            behavior: 'smooth'
        });
    }

    setInterval(() => {
        index = (index + 1) % slides.length;
        scrollToSlide(index);
    }, 3000);

