
$(document).ready(function() {

    var _body = $('body');
    var _tableBlock = $('#tableBlock');
    var _globalSearch = $('#globalsearch-query');

    //Корректируем блок экспорта
     $('#exportBtn').append($('#w3 > div.summary'));
    
    //Исправялем проблему с экспортом
    $(".dropdown-toggle").dropdown();

    //Иконка в mobile view
    $('#iconMenu').click(function() {
        $('#left-panel,#searchBlockMobile').toggle(400);//#left-panel-min,
    });
    //Небольшой эффект для строки поиска
    _body.on('focus', '#globalsearch-query', function () {
        if ($(window).width() > '767') {
            _globalSearch.animate({width: '15em'}, 400);
        }
    });
    _body.on('focusout', '#globalsearch-query', function () {
        if ($(window).width() > '767') {
            _globalSearch.animate({width: '12em'}, 400);
        }
    });

    //Меню левой панели
    if ($(window).width() < '767'){
        toggleMenu();
    }

    //Раскрыть левую панель
    function toggleMenu(){
        $('#filters > div > #filters').toggleClass('nav-stacked');
        $('#handbooks').toggleClass('nav-stacked');
    }

    //Скрываем / прячем панель
    _body.on('click', '#show-panel', function() {
        if ($('#left-panel').width() > 43 ) {
            console.log("width : " + $('#left-panel').width() + " unfold");
            unfold();


        } else {
            console.log("width : " + $('#left-panel').width() + " fold");
            fold();

        }
    });

    function unfold() {
        $('#left-panel').animate({ width: '2.8%' }, 100, function() {
            $('#left-panel').css({
                position: "absolute",
                zIndex: "100",
            });
            $('#tableBlock').css({
                marginLeft: "1.3%",
                paddingLeft: "2%",
                paddingRight: "2%",
                // paddingTop: "1%"
            });
            $('#tableBlock').removeClass();
            $('#tableBlock').addClass("col-lg-12 col-md-12 col-sm-12 col-xs-12");
        });

        //Уменьшаем нижнюю кнопку левой панели
        $('#show-panel').animate({ width: 40 }, 100);
        $('#show-panel i').removeClass();
        $('#show-panel i').addClass("fa fa-angle-right fa-2x");

        //Меняем иконку заголовка Tab - Фильтры
        $('#filterName').html("<i class='fa fa-filter' aria-hidden='true'></i>");
        $('#optionTransportName').html("<i class='fa fa-cogs' aria-hidden='true'></i>");


        $('#linkWg').html("<i class='fa fa-users' aria-hidden='true'></i>");
        $('#linkMy').html("<i class='fa fa-user-circle-o' aria-hidden='true'></i>");
        $('#linkDoneMe').html("<i class='fa fa-check-circle' aria-hidden='true'></i>");
        $('#dataSend').html("<i class='fa fa-check-circle' aria-hidden='true'></i>");
        $('#cancelClient').html("<i class='fa fa-times-circle' aria-hidden='true'></i>");
        $('#iconCar').html("<i class=\"fa fa-car\" aria-hidden=\"true\"></i>");
        $('#iconDriver').html("<i class=\"fa fa-id-card-o\" aria-hidden=\"true\"></i>");
    }
    //Спрятать левую панель
    function fold() {
        $('#left-panel').animate({ width: '16.6%' }, 100, function() {

            $('#linkWg').html("<i class='fa fa-users' aria-hidden='true'></i> На мои рабочие группы");
            $('#linkMy').html("<i class='fa fa-user-circle-o' aria-hidden='true'></i> Назначены мне");
            $('#linkDoneMe').html("<i class='fa fa-check-circle' aria-hidden='true'></i> Выполненные мной");
            $('#dataSend').html("<i class='fa fa-check-circle' aria-hidden='true'></i> Данные отправлены");
            $('#cancelClient').html("<i class='fa fa-times-circle' aria-hidden='true'></i> Отозваны клиентом");
            $('#iconCar').html("<i class=\"fa fa-car\" aria-hidden=\"true\"></i>&nbsp&nbsp Автомобили");
            $('#iconDriver').html("<i class=\"fa fa-id-card-o\" aria-hidden=\"true\"></i>&nbsp&nbsp Водители");

            $('#left-panel').css({
                position: "relative"
            });
            $('#tableBlock').css({
                marginLeft: "0"
            });

            $('#tableBlock').removeClass();
            $('#tableBlock').addClass("col-lg-10 col-md-10 col-sm-10 col-xs-12");
        });

        $('#show-panel').animate({ width: '100%' }, 100);
        $('#show-panel i').removeClass();
        $('#show-panel i').addClass("fa fa-angle-left fa-2x");

        $('#filterName').html("Фильтры");
        $('#optionTransportName').html("Справочники");

        // _filters.removeClass();
        // _filters.addClass("collapse in");
    }
    //Мониторит за размером окна
    $(window).resize(function() {
        var _searchBlockMobile = $('#searchBlockMobile');
        if ($(window).width() > '767') {
            _searchBlockMobile.css({ //#left-panel-min,
                display: "none"
            });
            $('#left-panel').css({
                display: "block"
            });
            //toggleMenu();
            if ($('#left-panel').width() > 40) {
                _tableBlock.removeClass();
                _tableBlock.addClass("col-lg-10 col-md-10 col-sm-10 col-xs-12");
            }
        } else {
            location.reload();
        }
    });
});

//progress bar
var options = {
    id: 'progressbar',
    target: document.getElementById('progressbar')
};

var nanobar = new Nanobar( options );
nanobar.go(100);

//Тултипы
$('input[rel="tooltip"]').each(function() {
    var label = $(this).val();
    if (label.length > 10) {
        $(this).tooltip({ 'trigger': 'hover', 'title': label });
    }
    // console.log(label);
});
//Прячем код закрытия "отозвано клиентом"
if ($("#requests-closure_code option:selected").val() != 3) {
    $("#requests-closure_code option[value=3]").remove();
}

if ($("#requeststransport-closure_code option:selected").val() != 3) {
    $("#requeststransport-closure_code option[value=3]").remove();
}

 // Прячем статус "отозвано клиентом"
var select=document.getElementById('requeststransport-status');
for (i=0;i<select.length;  i++) {
    if (select.options[i].value=='8') {
        select.remove(i);
    }
}

// Для заполнения решения в услугах по транспорту
// $('#requeststransport-driver_id').change(function() {
//     new_driver_fio = $(this).find(":selected").text();
//     // sleep(1000);
//     new_driver_number = $("#transportdriver-driver_phone").val();
//     new_car_brand = $("#transportcar-vehicle_brand").val();
//     new_car_id = $("#transportcar-vehicle_id_number").val();
//     current_solution = $("#requeststransport-solution").val();
//
//     starting_regexp = /^Назначена/i;
//     if (new_driver_fio !== '---') {
//         if (current_solution.match(starting_regexp)) {
//             $("#requeststransport-solution").val("Назначена машина: " + new_car_brand + ", " + new_car_id + ". Водитель: " + new_driver_fio + ", " + new_driver_number);
//         }
//         else {
//             $("#requeststransport-solution").val("Назначена машина: " + new_car_brand + ", " + new_car_id + ". Водитель: " + new_driver_fio + ", " + new_driver_number + "\n" + current_solution);
//         }
//     }
// });







// $('#left-panel .tab-content').css('height',($(document).height())-($("#block1").height()));