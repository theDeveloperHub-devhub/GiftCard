require(['jquery', 'mage/calendar'], function($) {
    $(document).ready(function() {
        $('#selected_date').calendar({
            dateFormat: 'yyyy-MM-dd',
            showsTime: false,
            buttonText: "Select Date",
            changeYear: true,
            changeMonth: true
        });
    });
});
