$(document).ready(function() {
    $('select').material_select();
    $('.modal-trigger').leanModal();

    // Validate search form
    if($('#search-form').length!=0) {
        $('#search-form').validate({
            errorPlacement: function errorPlacement(error, element) {
                element.addClass('invalid')
            },
        });
    }

    /**
     * Search box steps
     */
    $('#active-step').val('destination-container');
    // Next step
    $('.search-box #next').on('click', function () {
        if ($('#search-form').valid())
            $('#search-form').switchSearchTabs('next');
    });
    // Previous step
    $('.search-box #previous').on('click', function () {
        $('#search-form').switchSearchTabs('prev');
    });
    $('.search-box .tabs .tab a').on('click', function () {
        $('#active-step').val($(this).attr('id').substr(0, $(this).attr('id').lastIndexOf('-trigger')));
        if ($(this).attr('id') == 'rooms-trigger') {
            $('.search-box #next').addClass('hidden');
            $('.search-box #search').removeClass('hidden');
        }
        else {
            $('.search-box #next').removeClass('hidden');
            $('.search-box #search').addClass('hidden');
        }

        if ($(this).attr('id') == 'destination-container-trigger')
            $('.search-box #previous').addClass('disabled');
        else
            $('.search-box #previous').removeClass('disabled');
    });

    /**
     * Change rooms count dropdown list
     */
    $('#rooms-count').on('change', function () {
        var existsRoom=$('.room-info').find('.room-item').length;
        if(parseInt($(this).val())<existsRoom) {
            console.log(existsRoom - parseInt($(this).val()));
            for (var j = 0; j < existsRoom - parseInt($(this).val()); j++)
                $('.room-info').find('.room-item:nth-child(' + (existsRoom-j) + ')').remove();
        }
        else {
            for (var i = 0; i < parseInt($(this).val())-existsRoom; i++) {
                var roomsHtml=
                    '<div class="room-item clearfix">' +
                        '<h6 class="col-md-12">اتاق '+((existsRoom+1)+i)+'</h6>' +
                        '<div class="col-md-3">' +
                            '<div class="input-field">' +
                                '<select>' +
                                    '<option value="" disabled selected>بزرگسال</option>' +
                                    '<option value="1">1 نفر</option>' +
                                    '<option value="2">2 نفر</option>' +
                                    '<option value="3">3 نفر</option>' +
                                    '<option value="4">4 نفر</option>' +
                                '</select>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-3">' +
                            '<div class="input-field">' +
                                '<select class="kids-count-select">' +
                                    '<option value="" disabled selected>خردسال</option>' +
                                    '<option value="1">1 نفر</option>' +
                                    '<option value="2">2 نفر</option>' +
                                    '<option value="3">3 نفر</option>' +
                                '</select>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-md-6 kids-age-container"></div>' +
                    '</div>';
                $('.room-info').append(roomsHtml);
                $('.room-info select').material_select();
            }
        }
    });
    $('body').on('change', 'select.kids-count-select', function(){
        $(this).parents('.room-item').find('.kids-age-container').html('');
        for (var i = 0; i < parseInt($(this).val()); i++) {
            var kidsAgeHtml=
                '<div class="col-md-4">' +
                    '<div class="input-field">' +
                        '<select>' +
                            '<option value="" disabled selected>سن</option>' +
                            '<option value="1">0 تا 2</option>' +
                            '<option value="2">2 تا 7</option>' +
                            '<option value="3">7 تا 12</option>' +
                        '</select>' +
                    '</div>' +
                '</div>';
            $(this).parents('.room-item').find('.kids-age-container').append(kidsAgeHtml);
            $(this).parents('.room-item').find('.kids-age-container select').material_select();
        }
    });
});

jQuery.fn.switchSearchTabs=function(destination) {
    var nextStep,
        prevStep;
    switch ($('#active-step').val()) {
        case 'destination-container':
            nextStep = 'dates';
            prevStep = null;
            break;
        case 'dates':
            nextStep = 'rooms';
            prevStep = 'destination-container';
            break;
        case 'rooms':
            nextStep = null;
            prevStep = 'dates';
            break;
    }

    if(destination=='next') {
        if (nextStep != null) {
            $('#' + nextStep + '-trigger').parent('li').removeClass('disabled');
            $('#' + nextStep + '-trigger').trigger('click');
            $('.search-box #previous').removeClass('disabled');
            $('#active-step').val(nextStep);
            if (nextStep == 'rooms') {
                $('.search-box #next').addClass('hidden');
                $('.search-box #search').removeClass('hidden');
            }
        }
    }
    else {
        if (prevStep != null) {
            $('#' + prevStep + '-trigger').trigger('click');
            $('#active-step').val(prevStep);
            if (prevStep == 'destination-container')
                $('.search-box #previous').addClass('disabled');
            else if(prevStep == 'dates')
            {
                $('.search-box #next').removeClass('hidden');
                $('.search-box #search').addClass('hidden');
            }
        }
    }
}