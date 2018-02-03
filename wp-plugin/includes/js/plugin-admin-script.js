jQuery(document).ready(function($)
{
$(".fpec_date").datepicker({
    dateFormat: 'D, M d, yy',
    showOn: 'button',
    buttonImage: 'images/date-button.gif',
    buttonImageOnly: true,
    numberOfMonths: 3
    });
});
