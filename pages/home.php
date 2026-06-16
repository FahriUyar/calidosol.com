<?php
$pageTitle = t('seo_title');
$pageDescription = t('seo_description');
?>

<!-- Hero Section -->
<div class="hero-slider position-relative overflow-hidden" role="banner">
    <div id="mainHeroSplide" class="splide h-100">
        <div class="splide__track h-100">
            <ul class="splide__list h-100">
                <?php foreach (t('hero_slides', []) as $slide): ?>
                <li class="splide__slide position-relative h-100">
                    <img src="<?= e(asset($slide['image'])) ?>" 
                         alt="<?= e($slide['title']) ?>" 
                         class="hero-slider__bg object-fit-cover w-100 h-100" 
                         loading="lazy">
                    <div class="hero-slider__overlay position-absolute top-0 start-0 w-100 h-100"></div>
                    <div class="hero-slider__content position-absolute top-50 start-50 translate-middle text-center w-100 px-3 z-2">
                        <div class="container">
                            <h2 class="display-3 fw-bold text-white mb-3 text-shadow-sm slide-title opacity-0"><?= e($slide['title']) ?></h2>
                            <p class="fs-4 text-white opacity-90 slide-subtitle opacity-0"><?= e($slide['subtitle']) ?></p>

                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    

</div>

<!-- About Section -->
<section class="py-5 my-md-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="text-primary fw-bold text-uppercase tracking-wide small mb-2 d-block"><?= e(t('common.about_us')) ?></span>
                <h1 class="display-5 fw-bold mb-4" style="color: var(--color-text);"><?= e(t('about_title')) ?></h1>
                <div class="fs-5 text-muted lh-lg mb-5">
                    <?= t('about_content') ?>
                </div>
                <div class="d-inline-flex gap-2">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--color-primary);"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--color-primary); opacity: 0.5;"></span>
                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--color-primary); opacity: 0.2;"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Grid -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="h1 fw-bold"><?= e(t('facilities_title')) ?></h2>
            <div style="width: 60px; height: 3px; background-color: var(--color-primary); margin: 20px auto 0;"></div>
        </div>

        <div class="row g-4">
            <?php foreach (t('facilities', []) as $facility): ?>
            <div class="col-md-6 col-lg-4">
                <article class="facility-card h-100 rounded-4 overflow-hidden shadow-sm position-relative group">
                    <img src="<?= e(asset($facility['image'])) ?>" alt="<?= e($facility['title']) ?>" class="facility-card__img w-100 h-100 object-fit-cover transition-transform" loading="lazy">
                    <div class="facility-card__overlay position-absolute bottom-0 start-0 w-100 p-4 transition-all">
                        <h3 class="h4 text-white fw-bold mb-2"><?= e($facility['title']) ?></h3>
                        <a href="<?= e(page_url($facility['link'])) ?>" class="btn btn-outline-light rounded-pill btn-sm d-inline-flex align-items-center mt-2 opacity-0 transition-all facility-btn">
                            <?= e(t('common.view_details')) ?> <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php ob_start(); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('#mainHeroSplide')) {
        var splide = new Splide('#mainHeroSplide', {
            type: 'fade',
            rewind: true,
            autoplay: true,
            interval: 5000,
            pauseOnHover: false,
            arrows: true,
            pagination: true,
            speed: 1000,
        });

        splide.on('active', function (slide) {
            slide.slide.querySelectorAll('.opacity-0').forEach(el => {
                el.classList.add('animate-fade-up');
                el.classList.remove('opacity-0');
            });
        });

        splide.on('hidden', function (slide) {
            slide.slide.querySelectorAll('.animate-fade-up').forEach(el => {
                el.classList.remove('animate-fade-up');
                el.classList.add('opacity-0');
            });
        });

        splide.mount();
    }
});
</script>
<?php $extraScripts .= ob_get_clean(); ?>

<?php ob_start(); ?>
<style>
.facility-card { height: 320px; cursor: pointer; }
.facility-card__img { transition: transform 0.5s ease; }
.facility-card:hover .facility-card__img { transform: scale(1.05); }
.facility-card__overlay { 
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
    transition: all 0.3s ease;
}
.facility-card:hover .facility-btn { opacity: 1 !important; transform: translateY(0); }
.facility-btn { transform: translateY(10px); }

.hero-slider { height: 80vh; min-height: 500px; max-height: 800px; }
.hero-slider__overlay { background: rgba(0, 0, 0, 0.4); }
.text-shadow-sm { text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
.slide-title { animation-delay: 0.2s; }
.slide-subtitle { animation-delay: 0.4s; }
.slide-btn { animation-delay: 0.6s; }

.animate-fade-up {
    animation: fadeUp 0.8s forwards;
}

@keyframes fadeUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
<?php $extraHead .= ob_get_clean(); ?>
