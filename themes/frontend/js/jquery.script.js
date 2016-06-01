$(document).ready(function() {
    $('select').material_select();
    $('.modal-trigger').leanModal();

    /**
     * Call typeahead plugin for destination input
     */
    var destinationSource = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: 'postman/autoComplete/%QUERY',
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
    }).on('focus', function(){
        $(this).parents('.input-field').find('label').addClass('active');
    }).on('blur', function(){
        if($(this).val()=='')
            $(this).parents('.input-field').find('label').removeClass('active');
    }).on('typeahead:asyncrequest', function(){
        $(this).parents('.input-field').find('.auto-complete-loading').show();
    }).on('typeahead:asyncreceive', function(){
        $(this).parents('.input-field').find('.auto-complete-loading').hide();
    });

    /**
     *  Validate search form
     */
    if($('#search-form').length!=0) {
        $('#search-form').validate({
            errorPlacement: function errorPlacement(error, element) {
                element.addClass('invalid')
            },
        });
    }

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
                                    '<option value="0">بدون خردسال</option>' +
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