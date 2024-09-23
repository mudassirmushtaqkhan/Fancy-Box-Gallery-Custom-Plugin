

jQuery(document).ready(function ($) {
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "slideShow",
            "thumbs",
            "zoom",
            "fullScreen",
            "share",
            "close"
        ],
        loop: true,
        protect: true
    });

    var currentImageIndex = 0;
    var totalImages = $('.crexed-gallery-item').length;

    // Show first image initially
    $('.crexed-gallery-item').eq(currentImageIndex).show();

    // Next button click
    $('.crexed-next').on('click', function (e) {
        e.preventDefault();
        if (currentImageIndex < totalImages - 1) {
            $('.crexed-gallery-item').eq(currentImageIndex).hide();
            currentImageIndex++;
            $('.crexed-gallery-item').eq(currentImageIndex).show();
        }
    });

    // Previous button click
    $('.crexed-prev').on('click', function (e) {
        e.preventDefault();
        if (currentImageIndex > 0) {
            $('.crexed-gallery-item').eq(currentImageIndex).hide();
            currentImageIndex--;
            $('.crexed-gallery-item').eq(currentImageIndex).show();
        }
    });
});