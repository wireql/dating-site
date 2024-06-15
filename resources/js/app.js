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

});