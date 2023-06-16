jQuery(document).ready(function ($) {
  var sliders = $('.custom-product-slider');

  sliders.each(function (index) {
      var slider = $(this);
      var sliderInner = slider.find('.custom-product-slider-inner');
      var items = sliderInner.find('.custom-product-item');
      var totalItems = items.length;
      var visibleItems = 5;
      var itemWidth = 100 / visibleItems;
      var galleryId = 'product-gallery-' + index; // Generate unique gallery ID

      var currentIndex = 0;

      // Set initial width for items
      items.css('width', itemWidth + '%');

      // Update controls state
      function updateControlsState() {
          slider.find('.custom-product-slider-prev').toggleClass('disabled', currentIndex === 0);
          slider.find('.custom-product-slider-next').toggleClass('disabled', currentIndex >= totalItems - visibleItems);
      }

      // Slide to the next item
      function slideNext() {
          if (currentIndex < totalItems - visibleItems) {
              currentIndex++;
              sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
              updateControlsState();
          }
      }

      // Slide to the previous item
      function slidePrev() {
          if (currentIndex > 0) {
              currentIndex--;
              sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
              updateControlsState();
          }
      }

      // Attach click event to next button
      slider.on('click', '.custom-product-slider-next', slideNext);

      // Attach click event to previous button
      slider.on('click', '.custom-product-slider-prev', slidePrev);

      // Initialize the gallery
      function initializeGallery() {
          var gallery = $('#' + galleryId);

          gallery.find('.product-gallery-pager-dot').on('click', function () {
              var dot = $(this);
              var dotIndex = dot.data('index');

              currentIndex = dotIndex;
              sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
              updateControlsState();
          });
      }

      // Call the gallery initialization function
      initializeGallery();

      // Initial controls state
      updateControlsState();
  });
});
