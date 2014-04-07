var testing_data = {};

testing_data.loaded = function() {

    $('#input_p_name').attr('value', '');
    $('#input_p_number').attr('value', '');

    $('#input_e_content').moreText({n:8,corpus:'laihe'});
};


