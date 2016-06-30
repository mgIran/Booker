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
            minLength: 3,
            limit: 20,
            hint: false
        }, {
            name: 'destination',
            display: 'name',
            source: destinationSource
        }).on('focus', function () {
            $(this).parents('.input-field').find('label').addClass('active');
        }).on('blur', function () {
            if ($(this).val() == '')
                $(this).parents('.input-field').find('label').removeClass('active');
        }).on('typeahead:asyncrequest', function () {
            $(this).parents('.input-field').find('.auto-complete-loading').show();
        }).on('typeahead:asyncreceive', function (a, b, c) {
            $(this).parents('.input-field').find('.auto-complete-loading').hide();
        }).on('typeahead:selected', function (e, datum) {
            $('#city-key').val(datum.key);
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
                                        '<option value="" disabled selected>کودک</option>' +
                                        '<option value="0">0 نفر</option>' +
                                        '<option value="1">1 نفر</option>' +
                                        '<option value="2">2 نفر</option>' +
                                        '<option value="3">3 نفر</option>' +
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
});