import './bootstrap';

$(document).ready(function(){
    $('#telephone').inputmask('+7 999 999 99 99');

    $('#add-hobbies').click(function(e) {
        e.preventDefault();
        let newHobby = $('#new-hobby').val();
        if (newHobby) {
            let hobbyId = 'hobby-' + newHobby.toLowerCase().replace(/\s+/g, '-');
            $('#hobbies').append(
                '<div class="flex items-center mt-2">' +
                    '<input type="checkbox" name="hobbies[]" value="' + newHobby + '" id="' + hobbyId + '" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">' +
                    '<label for="' + hobbyId + '" class="ml-2 block text-sm text-gray-900">' + newHobby + '</label>' +
                '</div>'
            );
            $('#new-hobby').val('');
        }
    });

    $('#add-preference').click(function(e) {
        e.preventDefault();
        let newPreference = $('#new-preference').val().trim();
        if (newPreference) {
            let preferenceId = 'preference-' + newPreference.toLowerCase().replace(/\s+/g, '-');
            $('#preferences').append(
                '<div class="flex items-center mt-2">' +
                    '<input type="checkbox" name="preferences[]" value="' + newPreference + '" id="' + preferenceId + '" class="h-4 w-4 text-black border-gray-300 rounded focus:ring-black">' +
                    '<label for="' + preferenceId + '" class="ml-2 block text-sm text-gray-900">' + newPreference + '</label>' +
                '</div>'
            );
            $('#new-preference').val('');
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".setFavourite").click(function() {
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


});