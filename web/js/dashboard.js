LOGIN_SCENARIO = $('#user-login_scenario').val();
const controller = window.location.pathname.split('/')[5];
var lastSlash = location.href.lastIndexOf('/');           
var parentUrl = location.href.slice(0, lastSlash+1);

$(function() {
    getLoginScenario(LOGIN_SCENARIO)
    
    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        if ($(".page-wrapper").hasClass('toggled')) {
            $(".page-wrapper").removeClass('toggled');
        } else {
            $(".page-wrapper").addClass("toggled");
        }
    });

    $('.toggle-menu').click(function() {
        $('.exo-menu').toggleClass('display');

    });

    //upload users modal
    $('#upload').click(function(event) {
        event.preventDefault();
        $('#uploadModal').modal('show')
    });
    $('#uploadModal .close').css('display', 'none');
    $('#category_modal .close').css('display', 'none');


    //select category based on family choice
    $('#applicationlist-category').prop('disabled', true);
    $('#applicationlist-family').change(function() {
        var appl_family = $('#applicationlist-family').val();
        var url = parentUrl.replace(controller, 'category/get-categories')
        $('#applicationlist-category').prop('disabled', false);
        $.ajax({
            url: url,
            type: 'GET',
            data: {'appl_family':appl_family},
            dataType: 'json',
        }).done(function(response) {
            console.log(response)
            var categories = response
            $('#applicationlist-category').empty()
            $.each(categories, function( index, value ){
                $('#applicationlist-category').append(`<option value="${index}">${value}</option>`);
            });
        }).fail(function() {
            console.log("error");
        });
    });


    $('#created_on, #modified_on').mask('1234-56-780Hh:mm', {
        placeholder: "yyyy-mm-dd HH:mm",
        'translation': {
            '-': {
                pattern: /^((?!(0))[-]{1})$/,
                fallback: '-'
            },
            ':': {
                pattern: /^((?!(0))[:]{1})$/,
                fallback: ':'
            },
            1: { pattern: /[0-2*]/ },
            2: { pattern: /[0-9*]/ },
            3: { pattern: /[0-9*]/ },
            4: { pattern: /[0-9*]/ },
            5: { pattern: /[0-1*]/ },
            6: { pattern: /[1-9*]/ },
            7: { pattern: /[0-3*]/ },
            8: { pattern: /[0-9*]/ },
            0: {
                pattern: /^((?!(0))[/]{10})$/,
                fallback: ' '
            },
            'H': {
                pattern: /[0-2*]/,
                fallback: 0
            },
            'h': {
                pattern: /[0-9*]/,
                fallback: 0
            },
            'M': {
                pattern: /[0-5*]/,
                fallback: 0
            },
            'm': {
                pattern: /[0-9*]/,
                fallback: 0
            },
        }
    });

});

