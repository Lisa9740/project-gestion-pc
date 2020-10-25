$(function() {

    $(".owl-carousel").owlCarousel({
        items: 4,
        margin: 15,
        navElement: 'i',
        navText: ['<span class="btn btn-primary ml-2"><i class="fas fa-chevron-left"></i></span>', '<span class="btn btn-primary"><i class="fas fa-chevron-right "></i></span>'],
        navContainer: $(".nav-container"),
        nav: true,
    });

    const editComputerContainer = $('#edit-computer-container')
    const countIsAttributed = $('#is_select_date_attr').length



    const dateVal = $('#is_select_date_attr').data('attribution-date')
    if (dateVal !== null){
        $('#current-choose-date').text(dateVal);
    }else{
        $('#current-choose-date').text($('#date-input').val());
    }

    $.datepicker.regional['fr'] = {
        dateFormat: 'dd/mm/yy',
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
            'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
        monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
            'Jul','Aou','Sep','Oct','Nov','Dec'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        weekHeader: 'Sm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        minDate: 0,
        maxDate: '+12M +0D',
        numberOfMonths: 1,


    };
    $.datepicker.setDefaults($.datepicker.regional['fr']);
    $('#date-input').datepicker()


    const countAttributeCustomer = $('.attributed-customer + .add-customer-attribution').length;
    for (let y = 0; y < countAttributeCustomer; y++) {
        $('.attributed-customer').hide()
        $('.attributed-customer + .add-customer-attribution').hide()
    }

    $("#add-customer-attribution").on('shown.bs.modal', function (e) {
        const date = $('#date-input').val()
        const hour = $(e.relatedTarget).data('hour');
        const computer = $(e.relatedTarget).data('computer')
        $(this).find('#hour').val(hour)
        $(this).find('.attribution-hour').text(hour + 'h - Durée 1h' )
        $(this).find('.attribution-date').text(date)

        $(this).find('#date').val(date)
        $(this).find('#computer').val(computer)
    });

});
