require(
    ['jquery', 'mage/url'], function($, url) {
        console.log("JS Loaded Successfully!");
        $(document).ready(function() {
            $('#template').on('change', function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: url.build('developerhub/path/path'),
                    type: 'POST',
                    data: {
                        value: selectedValue
                    },
                    dataType: 'json'
                }).done(function (data)
                {
                    document.getElementById("show").innerHTML= "";
                    $('#show').append(`<img src="${data.url}" width="200" height="200" alt=""/>`);
                });
            });
            });
    });
