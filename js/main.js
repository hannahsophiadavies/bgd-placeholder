(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.fixed-top .container').addClass('shadow-sm').css('max-width', '100%');
        } else {
            $('.fixed-top .container').removeClass('shadow-sm').css('max-width', '85%');
        }
    });


    // Donation
    $('.progress').waypoint(function () {
        $('.progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {offset: '80%'});


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 5,
        time: 2000
    });


    // Event carousel
    $(".event-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: false,
        dots: false,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:2
            },
            1200:{
                items:3
            }
        }
    });

    // Contact Form AJAX Submission
    $("#contact-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize(); // Serialize form data
        var messageBox = $("#form-message"); // Target message div

        $.ajax({
            type: "POST",
            url: "contact-form.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                messageBox.text(response.message);
                messageBox.css("color", response.status === "success" ? "green" : "red");
                if (response.status === "success") {
                    $("#contact-form")[0].reset(); // Reset the form fields
                }
            },
            error: function () {
                messageBox.text("Error submitting form. Please try again.");
                messageBox.css("color", "red");
            }
        });
    });

    $(document).ready(function() {
        $("#newsletter-form").submit(function(event) {
            event.preventDefault(); // Prevents page refresh
    
            var email = $("#newsletter-email").val(); // Get email input
            var messageBox = $("#newsletter-message"); // Message area
    
            if (email === "") {
                messageBox.html("Please enter a valid email.").css("color", "red");
                return;
            }
    
            $.ajax({
                url: "newsletter.php", // The PHP script handling subscription
                type: "POST",
                data: { email: email },
                success: function(response) {
                    if (response === "success") {
                        messageBox.html("Thank you for subscribing!").css("color", "green");
                        $("#newsletter-email").val(""); // Clear input
                    } else if (response === "invalid") {
                        messageBox.html("Invalid email address.").css("color", "red");
                    } else if (response === "duplicate") {
                        messageBox.html("You are already subscribed.").css("color", "orange");
                    } else {
                        messageBox.html("Subscription failed. Please try again.").css("color", "red");
                    }
                },
                error: function() {
                    messageBox.html("An error occurred. Please try again.").css("color", "red");
                }
            });
        });
    });
    
    

    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


})(jQuery);

