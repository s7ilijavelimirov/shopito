var prevScrollpos = window.pageYOffset;
var timeout;
var navbar = document.getElementById("navbar");
var menuContainer = document.querySelector(".menu-main-menu-container");
var startScrollPos = 0;

window.onscroll = function () {
    var currentScrollPos = window.pageYOffset;
    clearInterval(timeout);
    timeout = setTimeout(function () {
        if (currentScrollPos == prevScrollpos) {
            if (currentScrollPos > 0) {
                navbar.style.transition = "top 0.5s ease-in-out, transform 0.5s ease-in-out";
                // Add padding to the nav element when scrolling up
                document.getElementById("main-nav").style.transition = "padding-top 0.5s ease-in-out, transform 0.5s ease-in-out";
                document.getElementById("main-nav").style.transform = "translateY(0)";
                document.getElementById("main-nav").style.paddingTop = "10px";
            } else {
                navbar.style.transition = "top 0.5s ease-in-out, transform 0.5s ease-in-out";
                navbar.classList.remove("scroll-up");
                // Reset padding when scrolled back to the top
                document.getElementById("main-nav").style.transition = "padding-top 0.5s ease-in-out, transform 0.5s ease-in-out";
                document.getElementById("main-nav").style.transform = "translateY(0)";
                document.getElementById("main-nav").style.paddingTop = "40px"; // Promenjeno na 40px
            }
        }
    }, 0);

    if (prevScrollpos > currentScrollPos) {
        navbar.style.top = "0";
        navbar.style.transform = "translateY(0)";
        navbar.style.transition = "top 0.5s ease-in-out, transform 0.5s ease-in-out";
        navbar.classList.add("scroll-up"); // add a class to the navbar

        // Show menu container if header is at the top position
        if (currentScrollPos === startScrollPos) {
            menuContainer.style.opacity = "1";
            menuContainer.style.transition = "opacity 0.5s ease-in-out, transform 0.5s ease-in-out";
            menuContainer.removeAttribute("hidden");
            menuContainer.style.transform = "translateY(-30%)";
            setTimeout(function () {
                menuContainer.style.transition = "opacity 0.5s ease-in-out, transform 0.5s ease-in-out";
                menuContainer.style.transform = "translateY(0)";
            }, 200); // Dodato kašnjenje od 1 sekunde
        }
    } else if (prevScrollpos < currentScrollPos) {
        //navbar.style.top = "-103px";
        navbar.style.transform = "translateY(-100%)";
        navbar.style.transition = "top 0.5s ease-in-out, transform 0.5s ease-in-out";
        navbar.classList.remove("scroll-up"); // remove the class from the navbar

        // Hide menu container
        menuContainer.style.opacity = "0";
        menuContainer.style.transition = "opacity 0.5s ease-in-out, transform 0.5s ease-in-out";
        menuContainer.setAttribute("hidden", "true");
        menuContainer.style.transform = "translateY(-50%)";
    }

    // Hide menu container if scrolled to the bottom
    if (currentScrollPos === (document.documentElement.scrollHeight - window.innerHeight)) {
        menuContainer.style.opacity = "0";
        menuContainer.style.transition = "opacity 0.5s ease-in-out, transform 0.5s ease-in-out";
        menuContainer.setAttribute("hidden", "true");
        menuContainer.style.transform = "translateY(-0%)";
    }

    prevScrollpos = currentScrollPos;
};
jQuery(document).ready(function ($) {
    var mobileMenuToggle = $('.mobile-menu-toggle');
    var mobileMenu = $('.mobile-menu-1');

    mobileMenuToggle.on('click', function () {
        mobileMenu.toggleClass('active');
        mobileMenuToggle.toggleClass('active');
    });
    var menuItems = document.querySelectorAll('.menu-item-has-children > a');

    menuItems.forEach(function (item) {
        var toggleIcon = document.createElement('span');
        toggleIcon.classList.add('toggle-icon');
        item.appendChild(toggleIcon);

        item.addEventListener('click', function (e) {
            e.preventDefault();
            var subMenu = this.nextElementSibling;
            var icon = this.querySelector('.toggle-icon');
            subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block';
            this.classList.toggle('active');
            // icon.textContent = this.classList.contains('active') ? '-' : '+';
        });
    });
    var cartCount = document.querySelector('.misha-cart');
    var menuItem = document.querySelector('ul#woo-menu > li:last-of-type');

    menuItem.appendChild(cartCount);


    // Prikazuje inicijalni prikaz proizvoda (grid)
    showShopView('grid');

    // Postavlja događaj klika na stavke u shop-view-switcher
    $('.shop-view-switcher a').on('click', function (e) {
        e.preventDefault();

        // Dohvaća odabrani način prikaza iz data-view atributa
        var view = $(this).data('view');

        // Prikazuje odabrani način prikaza proizvoda
        showShopView(view);

        // Uklanja klasu active sa svih stavki i dodaje je samo odabranoj stavki
        $('.shop-view-switcher li').removeClass('active');
        $(this).parent('li').addClass('active');
    });

    // Funkcija za prikaz odabranog načina prikaza proizvoda
    function showShopView(view) {
        // Uklanja sve postojeće klase za prikaz (grid, list)
        $('.products').removeClass('grid list');

        // Dodaje klasu za odabrani prikaz proizvoda (grid ili list)
        $('.products').addClass(view);
    }



    $('#menu-item-200 .fa-bag-shopping').on('click', function (e) {
        e.preventDefault();
        $(document.body).trigger('wc_fragment_refresh');
        $(document.body).trigger('open_cart');
    });

    $('.product-gallery-pager-dot').on('click', function (event) {
        event.preventDefault();
        var index = $(this).data('index');
        var galleryId = $(this).data('gallery');

        $('#' + galleryId + ' .product-gallery-pager-dot').removeClass('active');
        $(this).addClass('active');

        $('#' + galleryId + ' .product-gallery-image').removeClass('active');
        $('#' + galleryId + ' .product-gallery-image').eq(index).addClass('active');

        $('#' + galleryId + ' .product-gallery-images').addClass('active');
    });

    // const menuContainer = $('.minicarts');
    // const miniCart = $('.mini-cart');

    // let opened = false;

    // menuContainer.on('click', function () {
    //     opened = !opened;
    //     miniCart.toggleClass('open');
    // });

    $('.minicarts').on('click', function (event) {
        event.stopPropagation(); // Zaustavi širenje događaja
        $('body').toggleClass('open');
        $('body').toggleClass('color-change'); // Dodajemo klasu za promenu boje
    });

    $('body').on('click', function (event) {
        if ($(event.target).closest('.minicarts').length === 0 && $('body').hasClass('open')) {
            $('body').removeClass('open');
            $('body').removeClass('color-change'); // Uklanjamo klasu za promenu boje
        }
    });
    $('.mini-cart').on('click', function (event) {
        event.stopPropagation(); // Zaustavi širenje događaja
    });
    $('.product').each(function () {
        var productLink = $(this).find('.woocommerce-LoopProduct-link.woocommerce-loop-product__link');
        var productUrl = productLink.attr('href');

        productLink.click(function (e) {
            e.stopPropagation();
            window.location.href = $(this).attr('href');
        });

        productLink.attr('href', productUrl);
    });



    // CUSTOM SLIDER



    var sliders = $('.custom-product-slider');

    sliders.each(function (index) {
        var slider = $(this);
        var sliderInner = slider.find('.custom-product-slider-inner');
        var items = sliderInner.find('.custom-product-item');
        var visibleItems = slider.data('visible-items');
        var itemWidth = 100 / visibleItems;

        var currentIndex = 0;

        // Set initial width for items
        items.css('width', itemWidth + '%');

        // Update controls state
        function updateControlsState() {
            slider.find('.custom-product-slider-prev').toggleClass('disabled', currentIndex === 0);
            slider.find('.custom-product-slider-next').toggleClass('disabled', currentIndex >= items.length - visibleItems);
        }

        // Slide to the next item
        function slideNext() {
            if (currentIndex < items.length - visibleItems) {
                currentIndex++;
                sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
                updateControlsState();
                updateDotsState();
            }
        }

        // Slide to the previous item
        function slidePrev() {
            if (currentIndex > 0) {
                currentIndex--;
                sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
                updateControlsState();
                updateDotsState();
            }
        }

        // Attach click event to next button
        slider.on('click', '.custom-product-slider-next', slideNext);

        // Attach click event to previous button
        slider.on('click', '.custom-product-slider-prev', slidePrev);

        // Generate dots
        var dotsContainer = slider.find('.custom-product-slider-dots');

        for (var i = 0; i < items.length - visibleItems + 1; i++) {
            var dot = $('<span>').addClass('dot').data('index', i);

            if (i === currentIndex) {
                dot.addClass('active');
            }

            dotsContainer.append(dot);
        }

        // Update dots state
        function updateDotsState() {
            dotsContainer.find('.dot').removeClass('active');
            dotsContainer.find('.dot').eq(currentIndex).addClass('active');
        }

        // Attach click event to dots
        dotsContainer.on('click', '.dot', function () {
            var dotIndex = $(this).data('index');
            currentIndex = dotIndex;
            sliderInner.css('transform', 'translateX(' + (-currentIndex * itemWidth) + '%)');
            updateControlsState();
            updateDotsState();
        });

        // Initial controls state
        updateControlsState();
    });

});

