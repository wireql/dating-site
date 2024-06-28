import './bootstrap';

$(document).ready(function(){
    $('#telephone').inputmask('+7 999 999 99 99');

    $('#add-hobbies').click(function(e) {
        e.preventDefault();
        let newHobby = $('#new-hobby').val();
        if (newHobby) {
            $('#hobbies').append(
                '<div class="flex items-center mt-2">' +
                    '<input type="checkbox" name="hobbies[new][]" value="' + newHobby + '" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">' +
                    '<label class="ml-2 block text-sm text-gray-900">' + newHobby + '</label>' +
                '</div>'
            );
            $('#new-hobby').val('');
        }
    });

    $('#add-preference').click(function(e) {
        e.preventDefault();
        let newPreference = $('#new-preference').val().trim();
        if (newPreference) {
            $('#preferences').append(
                '<div class="flex items-center mt-2">' +
                    '<input type="checkbox" name="preferences[new][]" value="' + newPreference + '" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">' +
                    '<label class="ml-2 block text-sm text-gray-900">' + newPreference + '</label>' +
                '</div>'
            );
            $('#new-preference').val('');
        }
    });

    $('#add-preferencesabot').click(function(e) {
        e.preventDefault();
        let newPreference = $('#new-preferencesabot').val().trim();
        if (newPreference) {
            $('#preferencesabot').append(
                '<div class="flex items-center mt-2">' +
                    '<input type="checkbox" name="preferencesabot[new][]" value="' + newPreference + '" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">' +
                    '<label class="ml-2 block text-sm text-gray-900">' + newPreference + '</label>' +
                '</div>'
            );
            $('#new-preferencesabot').val('');
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".setFavourite").click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        $.ajax({
            url: "/profile/favourites/add",
            method: "POST",
            data: {
                profile_id: $(this).data('profile_id')
            },
            success: function(response, textStatus, xhr) {
                $("#resp-message").html(`<span class="text-green-400">`+response.message+`</span>`)

                if(response.status == 100) {
                    $(".setFavourite[data-profile_id='" + response.profile_id + "'].active").removeClass('hidden');
                    $(".setFavourite[data-profile_id='" + response.profile_id + "']:not(.active)").addClass('hidden');
                }else {
                    $(".setFavourite[data-profile_id='" + response.profile_id + "'].active").addClass('hidden');
                    $(".setFavourite[data-profile_id='" + response.profile_id + "']:not(.active)").removeClass('hidden');
                }
            },
            error: function(xhr) {
                switch (xhr.status) {
                    case 400:
                        $("#resp-message").html(`<span class="text-orange-300">`+xhr.responseJSON.message+`</span>`)
                        break;
                
                    default:
                        $("#resp-message").html(`<span class="text-red-400">`+xhr.responseJSON.message+`</span>`)
                        break;
                }
            }
        });
    })


    let currentStep = 0;
    let steps = $(".step");

    function showStep(step) {
        steps.removeClass("active");
        steps.eq(step).addClass("active");
    }

    $(".btn-next").click(function() {
        currentStep++;
        showStep(currentStep);
    });

    $(".btn-prev").click(function() {
        currentStep--;
        showStep(currentStep);
    });


    $('.prc-crd-1').click(function(){
        $().simpleModal({
            name: 'example',
            title: 'Тариф 5 анкет',
            content: 'Чтобы купить: <br>Переведите 1000₸ на номер 7 (999) 999-99-99<br>Отправьте чек на Whatsapp 7 (999) 999-99-99',
            size: 'small', // or integer for px
            freeze: true,
        });
    });

    $('.prc-crd-2').click(function(){
        $().simpleModal({
            name: 'example',
            title: 'Тариф 10 анкет',
            content: 'Чтобы купить: <br>Переведите 2000₸ на номер 7 (999) 999-99-99<br>Отправьте чек на Whatsapp 7 (999) 999-99-99',
            size: 'small', // or integer for px
            freeze: true,
        });
    });

    $('.prc-crd-3').click(function(){
        $().simpleModal({
            name: 'example',
            title: 'Тариф 10 анкет + соц. сети',
            content: 'Чтобы купить: <br>Переведите 2500₸ на номер 7 (999) 999-99-99<br>Отправьте чек на Whatsapp 7 (999) 999-99-99',
            size: 'small', // or integer for px
            freeze: true,
        });
    });


});