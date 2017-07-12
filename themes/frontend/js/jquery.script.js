$(document).ready(function() {
    $('select').material_select();
    $('.modal-trigger').leanModal();

    /**
     * Call typeahead plugin for destination input
     */
    if($('#destination').length!=0) {
        var destinationSource = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: hotelAutoCompleteUrl,
                wildcard: '%QUERY'
            }
        });
        $('#destination').typeahead({
            minLength: 2,
            limit: 20,
            hint: false
        }, {
            name: 'destination',
            display: 'name',
            source: destinationSource,
            templates: {
                empty: [
                    '<div class="auto-complete-message">',
                    'نتیجه ای یافت نشد.',
                    '</div>'
                ].join('\n')
            }
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:asyncrequest', function () {
            if ($(this).css('direction') == 'rtl')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('right').addClass('left');
            else if ($(this).css('direction') == 'ltr')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('left').addClass('right');
            $(this).parents('.input-field').find('.auto-complete-loading').show();
        }).on('typeahead:asyncreceive', function (a, b, c) {
            $(this).parents('.input-field').find('.auto-complete-loading').hide();
        }).on('typeahead:selected', function (e, datum) {
            $('#city-key').val(datum.key);
        });
    }

    if($('#non-dom-flight-departure').length!=0) {
        var flightDepartureSource = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: flightAutoCompleteUrl,
                wildcard: '%QUERY'
            }
        });
        $('#non-dom-flight-departure').typeahead({
            minLength: 2,
            limit: 20,
            hint: false
        }, {
            name: 'non-dom-flight-departure',
            display: 'name',
            source: flightDepartureSource,
            templates: {
                empty: [
                    '<div class="auto-complete-message">',
                    'نتیجه ای یافت نشد.',
                    '</div>'
                ].join('\n')
            }
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:asyncrequest', function () {
            if ($(this).css('direction') == 'rtl')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('right').addClass('left');
            else if ($(this).css('direction') == 'ltr')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('left').addClass('right');
            $(this).parents('.input-field').find('.auto-complete-loading').show();
        }).on('typeahead:asyncreceive', function (a, b, c) {
            $(this).parents('.input-field').find('.auto-complete-loading').hide();
        }).on('typeahead:selected', function (e, datum) {
            $('#non-dom-flight-departure-iata').val(datum.iata);
            $('#non-dom-flight-from-is-city').val(datum.isCity);
        });
    }

    if($('#non-dom-flight-arrival').length!=0) {
        var flightArrivalSource = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: flightAutoCompleteUrl,
                wildcard: '%QUERY'
            }
        });
        $('#non-dom-flight-arrival').typeahead({
            minLength: 2,
            limit: 20,
            hint: false
        }, {
            name: 'non-dom-flight-arrival',
            display: 'name',
            source: flightArrivalSource,
            templates: {
                empty: [
                    '<div class="auto-complete-message">',
                    'نتیجه ای یافت نشد.',
                    '</div>'
                ].join('\n')
            }
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:asyncrequest', function () {
            if ($(this).css('direction') == 'rtl')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('right').addClass('left');
            else if ($(this).css('direction') == 'ltr')
                $(this).parents('.input-field').find('.auto-complete-loading').removeClass('left').addClass('right');
            $(this).parents('.input-field').find('.auto-complete-loading').show();
        }).on('typeahead:asyncreceive', function (a, b, c) {
            $(this).parents('.input-field').find('.auto-complete-loading').hide();
        }).on('typeahead:selected', function (e, datum) {
            $('#non-dom-flight-arrival-iata').val(datum.iata);
            $('#non-dom-flight-to-is-city').val(datum.isCity);
        });
    }

    if($('#dom-flight-departure').length!=0 || $('#dom-flight-arrival').length!=0) {
        var domesticAirports = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            identify: function (obj) {
                return obj.title;
            },
            prefetch: domesticAirportsUrl
        });

        function domesticAirportsDefaults(q, sync) {
            if (q === '') {
                sync(domesticAirports.get('تهران - فرودگاه مهرآباد', 'مشهد - فرودگاه مشهد', 'شیراز - فرودگاه شیراز', 'اصفهان - فرودگاه اصفهان', 'جزیره کیش - فرودگاه جزیره کیش'));
            }

            else {
                domesticAirports.search(q, sync);
            }
        }
    }

    if($('#dom-flight-departure').length!=0) {
        $('#dom-flight-departure').typeahead({
            minLength: 0,
            limit: 20,
            hint: false
        }, {
            name: 'flight-departure-domestic',
            display: 'title',
            source: domesticAirportsDefaults,
            templates: {
                empty: [
                    '<div class="auto-complete-message">',
                    'نتیجه ای یافت نشد.',
                    '</div>'
                ].join('\n')
            }
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:selected', function (e, datum) {
            $('#dom-flight-departure-iata').val(datum.iata);
        });
    }

    if($('#dom-flight-arrival').length!=0) {
        $('#dom-flight-arrival').typeahead({
            minLength: 0,
            limit: 20,
            hint: false
        }, {
            name: 'dom-flight-arrival',
            display: 'title',
            source: domesticAirportsDefaults,
            templates: {
                empty: [
                    '<div class="auto-complete-message">',
                    'نتیجه ای یافت نشد.',
                    '</div>'
                ].join('\n')
            }
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:selected', function (e, datum) {
            $('#dom-flight-arrival-iata').val(datum.iata);
        });
    }

    /**
     * Change rooms count dropdown list
     */
    $('#rooms-count').on('change', function () {
        var existsRoom=$('.room-info').find('.room-item').length;
        if(parseInt($(this).val())<existsRoom) {
            for (var j = 0; j < existsRoom - parseInt($(this).val()); j++)
                $('.room-info').find('.room-item:nth-child(' + (existsRoom-j) + ')').remove();
        }
        else {
            for (var i = 0; i < parseInt($(this).val())-existsRoom; i++) {
                var roomsHtml='',
                    template=$(this).data('template');
                if(template == 'normal') {
                    roomsHtml=
                        '<div class="room-item clearfix">' +
                            '<h6 class="col-md-12">اتاق '+((existsRoom+1)+i)+'</h6>' +
                            '<div class="col-md-3">' +
                                '<div class="input-field">' +
                                    '<select class="adults-count" name="rooms['+((existsRoom+1)+i)+'][adults]">' +
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
                                    '<select class="kids-count-select" name="rooms['+((existsRoom+1)+i)+'][kids]">' +
                                        '<option value="0" selected>0 کودک</option>' +
                                        '<option value="1">1 کودک</option>' +
                                        '<option value="2">2 کودک</option>' +
                                        '<option value="3">3 کودک</option>' +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col-md-6 kids-age-container"></div>' +
                            '<input type="hidden" id="room-num" value="'+((existsRoom+1)+i)+'">' +
                        '</div>';
                }else if(template=='pretty') {
                    roomsHtml=
                        '<div class="room-item clearfix container-fluid">' +
                            '<h6 class="col-md-1 room-label">اتاق <b>'+((existsRoom+1)+i).toString().toPersianDigit()+'</b></h6>' +
                            '<div class="col-md-8 rooms-info-container">' +
                                '<div class="col-md-3">' +
                                    '<div class="input-field">' +
                                        '<select class="adults-count" name="rooms['+((existsRoom+1)+i)+'][adults]">' +
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
                                        '<select class="kids-count-select" name="rooms['+((existsRoom+1)+i)+'][kids]">' +
                                            '<option value="" disabled selected>کودک</option>' +
                                            '<option value="0">0 نفر</option>' +
                                            '<option value="1">1 نفر</option>' +
                                            '<option value="2">2 نفر</option>' +
                                            '<option value="3">3 نفر</option>' +
                                        '</select>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col-md-6 kids-age-container"></div>' +
                                '<input type="hidden" id="room-num" value="<?php echo ($i+1);?>">' +
                            '</div>' +
                        '</div>';
                }

                $('.room-info').append(roomsHtml);
                $('.room-info select').material_select();
            }
        }
    });
    $('body').on('change', 'select.kids-count-select', function(){
        $(this).parents('.room-item').find('.kids-age-container').html('');
        var roomNum=$(this).parents('.room-item').find('#room-num').val();
        for (var i = 0; i < parseInt($(this).val()); i++) {
            var kidsAgeHtml=
                '<div class="col-md-4">' +
                    '<div class="input-field">' +
                        '<select class="kids-age" name="rooms['+roomNum+'][kids_age]['+(i+1)+']">' +
                            '<option value="" disabled selected>سن</option>' +
                            '<option value="2">0 تا 2</option>' +
                            '<option value="7">2 تا 7</option>' +
                            '<option value="12">7 تا 12</option>' +
                        '</select>' +
                    '</div>' +
                '</div>';
            $(this).parents('.room-item').find('.kids-age-container').append(kidsAgeHtml);
            $(this).parents('.room-item').find('.kids-age-container select').material_select();
        }
    });

    /**
     * Fixing fixable div
     */
    $(window).scroll(function() {
        if($('.hotels-container').length > 0) {
            if ($(this).scrollTop() > $('.hotels-container').offset().top) {
                $(".fixable").addClass('fixed');
                $(".hotels-container").addClass('fixed-container');
            }else {
                $(".fixable").removeClass('fixed');
                $(".hotels-container").removeClass('fixed-container');
            }
            $('.fixable').attr('style','');
            $('.filter-hotel .chevron-down i').text('keyboard_arrow_down');
        }
    });

    /**
     * Call popover
     */
    $('[data-toggle="popover"]').popover();
});

function waitAnimate() {
    $('.wa-circle').animate({
        width: 25,
        height: 25
    }, 2000, function () {
        $('.wa-v-line').animate({
            height: 150
        }, 2000, function () {
            $('.f1 .wa-disc').animate({
                width: 12,
                height: 12,
                marginTop: -6,
                marginLeft: 0,
                marginRight: 0
            }, function(){
                $('.f1 .wa-content').animate({
                    width: 280,
                    height: 46,
                    margin: 0,
                    opacity: 1
                }, 'slow', function(){
                    $('.f1 .wa-content > div').fadeIn();
                    $('.f1 .wa-h-line').delay(200).fadeIn(function(){
                        $('.wa-v-line').animate({
                            height: 300
                        }, 2000, function () {
                            $('.f2 .wa-disc').animate({
                                width: 12,
                                height: 12,
                                marginTop: -6,
                                marginLeft: 0,
                                marginRight: 0
                            }, function(){
                                $('.f2 .wa-content').animate({
                                    width: 280,
                                    height: 46,
                                    margin: 0,
                                    opacity: 1
                                }, 'slow', function(){
                                    $('.f2 .wa-content > div').fadeIn();
                                    $('.f2 .wa-h-line').delay(200).fadeIn(function(){
                                        $('.wa-v-line').animate({
                                            height: 400
                                        }, 2000, function () {
                                            $('.f3 .wa-disc').animate({
                                                width: 12,
                                                height: 12,
                                                marginTop: -6,
                                                marginLeft: 0,
                                                marginRight: 0
                                            }, function(){
                                                $('.f3 .wa-content').animate({
                                                    width: 280,
                                                    height: 46,
                                                    margin: 0,
                                                    opacity: 1
                                                }, 'slow', function(){
                                                    $('.f3 .wa-content > div').fadeIn();
                                                    $('.f3 .wa-h-line').delay(200).fadeIn(function(){
                                                        $('.wa-v-line').animate({
                                                            height: 500
                                                        }, 2000, function () {
                                                            $('.wa-finish-disc').fadeIn();
                                                            $('.f4 .wa-disc').animate({
                                                                width: 12,
                                                                height: 12,
                                                                marginTop: -6,
                                                                marginLeft: 0,
                                                                marginRight: 0
                                                            }, function(){
                                                                $('.f4 .wa-content').animate({
                                                                    width: 280,
                                                                    height: 46,
                                                                    margin: 0,
                                                                    opacity: 1
                                                                }, 'slow', function(){
                                                                    $('.f4 .wa-content > div').fadeIn();
                                                                    $('.f4 .wa-h-line').delay(200).fadeIn();
                                                                });
                                                            });
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        });
    });
}

function getHoursAndMinutes(minute) {
    var hours = parseInt(minute / 60),
        minutes = minute % 60;

    return {hour: hours, minute: minutes};
}

function getTimeFromString(str, domestic) {
    var matches;
    if (str) {
        if (domestic) {
            matches = str.match(/\d{2}:\d{2}/);
            return matches[0];
        } else {
            matches = str.match(/(\d{2}:){2}/);
            return matches[0].substr(0, matches[0].length - 1);
        }
    } else
        return '';
}
function getDateFromString(str) {
    if (str) {
        var matches = str.match(/\d{4}-\d{2}-\d{2}/);
        return matches[0].replace('-', '/').replace('-', '/');
    } else
        return '';
}