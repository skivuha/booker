$(document).ready(
    function()
    {
        $('#recuringon').on('click', function(){
                $('#recurring').css('display', 'block');
            }
        );
        $('#recuringoff').on('click', function(){
                $('#recurring').css('display', 'none');
            }
        );

        var height = (screen.height/2)-150;
        var widht = (screen.width/2)-150;
        $('.event').bind('click', function () {
            var target = event.target || event.srcElement;
            window.open('/~user2/PHP/booker/Employee/index/', 'Appointment', 'location, width = 300px,' +
            'height = 300px, top = '+height+'px, left = '+widht+'px').focus();
        });

        $('.deleteEmp').on('click', function(){
            if(confirm('Are you sure you want to delete this contact?'))
            {
                return true;
            }
            else
            {
                return false;
            }
        });

        var now = new Date();
        var currentYear = now.getFullYear();
        var currentMonth = now.getMonth();
        var currentDay = now.getDate();

        var listYear = '';
        var futureYear;
        for(var i = 0; i <= 5; i++)
        {
            futureYear = new Date(currentYear+i,0,1);
            var year = futureYear.getFullYear();
            listYear += '<option value="'+year+'">'+year+'</option>';
        }
        $('#dropdownyear').html(listYear);

        var lang = getCookie('langanator');

        if('en' == lang)
        {
            var monthName = new Array('January', 'February', 'March', 'April', 'May',
                'June', 'July', 'August', 'September', 'October', 'November', 'December');
        }else {
            var monthName = new Array('Январь', 'Февраль', 'Март', 'Апрель', 'Май',
                'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
        }
        var listMonth = '';
        for(var i = 0; i <= 11; i++)
        {
            futureYear = new Date(currentYear,0+i,1);
            var month = futureYear.getMonth();
            listMonth += '<option value="'+i+'">'+monthName[i]+'</option>';
        }

        $('#dropdownmonth').html(listMonth);

        $('option[value="'+currentYear+'"]').attr('selected','selected');
        $('option[value="'+currentMonth+'"]').attr('selected','selected');



        var selectedYear = $('#dropdownyear :selected').text();
        var selectedMonth = $('#dropdownmonth :selected').attr('value');


        var listDay = '';
        var selectedYearMonth = new Date(selectedYear, selectedMonth, 1);
        var dayInMonth = selectedYearMonth.daysInMonth();
        for(var i = 1; i <= dayInMonth ; i++)
        {
            var weekend = new Date(selectedYear, selectedMonth, i).getDay();
            if( 0 == weekend || 6 == weekend )
            {
                listDay += '<option disabled value="'+i+'">'+i+'</option>';
            }
            else {
                listDay += '<option value="' + i + '">' + i + '</option>';
            }
        }

        $('#dropdownday').html(listDay);
        $('option[value="'+currentDay+'"]').attr('selected','selected');
        setSelectedData();

        var hourFormat = getCookie('user2_timeFormat');
        var listHour = '';
        if('12h' == hourFormat) {
            setValueStartHour();
            setValueEndHour();
        }
        if('24h' == hourFormat)
        {
            for(var i = 0; i <= 23; i++)
            {
                if(10 > i) {
                    listHour += '<option value="' + '0' + i + '">' + '0' + i + '</option>';
                }else
                {
                    listHour += '<option value="' + i + '">' + i + '</option>';
                }
            }
            $('#dropdowntypestart, #dropdowntypeend').attr('disabled', 'disabled').css('color', '#ccc');

        }
        else
        {
            for(var i = 0; i <= 12; i++)
            {
                if('12h' == hourFormat) {
                    if (10 > i) {
                        listHour += '<option value="' + '0' + i + '">' + '0' + i + '</option>';
                    } else {
                        listHour += '<option value="' + i + '">' + i + '</option>';
                    }
                }
            }
        }
        $('#dropdownhourstart, #dropdownhourend').html(listHour);
        setMaxDuration();
        $('#savemodal').on('click', function(){
            addEvent();
        });
    }
);

Date.prototype.daysInMonth = function() {
    return 32 - new Date(this.getFullYear(), this.getMonth(), 32).getDate();
};

function setSelectedData()
{
    $('#dropdownyear, #dropdownmonth').on('click', function(){
        var now = new Date();
        var selectedDay = $('#dropdownday :selected').text();
        var selectedYear = $('#dropdownyear :selected').text();
        var selectedMonth = $('#dropdownmonth :selected').attr('value');
        var currentMonth = now.getMonth();
        var currentYear = now.getFullYear();
        var listDay = '';
        var selectedYearMonth = new Date(selectedYear, selectedMonth, 1);
        var dayInMonth = selectedYearMonth.daysInMonth();
        for(var i = 1; i <= dayInMonth ; i++)
        {
            var weekend = new Date(selectedYear, selectedMonth, i).getDay();
            if( 0 == weekend || 6 == weekend
                || ((currentMonth > selectedMonth
                &&  currentYear >= selectedYear)))
            {
                listDay += '<option disabled value="'+i+'">'+i+'</option>';
            }
            else {
                listDay += '<option value="' + i + '">' + i + '</option>';
            }
        }

        $('#dropdownday').html(listDay);
        $('#dropdownday option[value="'+selectedDay+'"]').attr('selected','selected');
    });
}

function setValueStartHour()
{
    $('#dropdowntypestart, #dropdownhourstart').on('click', function() {
        var value = $('#dropdownhourstart :selected').attr('value');
        var start = $('#dropdowntypestart :selected').text();
        var hourStart = $('#dropdownhourstart :selected').attr('value');
        var pm = 12;
        if('PM' == start)
        {
            $('#dropdownhourstart option:contains(00)').attr('disabled','disabled');
            if('00' == hourStart)
            {
                $('#dropdownhourstart option:contains(01)').attr('selected','selected')
            }
            var selectedHour = parseInt($('#dropdownhourstart :selected').text()) + pm;
            if(24 == selectedHour)
            {
                selectedHour = '12';
            }

            $('#dropdownhourstart :selected').attr('value', selectedHour);
            $('#dropdownhourstart option:contains(12)').removeAttr('disabled');
        }
        if('AM' == start)
        {
            if( 12 <= value )
            {
                var selectedHour = parseInt(hourStart) - pm;
            }
            $('#dropdownhourstart :selected').attr('value', selectedHour);
            $('#dropdownhourstart option[value="00"]').removeAttr('disabled');
            $('#dropdownhourstart option:contains(12)').attr('disabled','disabled');
            if('12' == hourStart)
            {
                $('#dropdownhourstart option:contains(11)').attr('selected','selected')
            }
        }
    })
}
function setValueEndHour() {
    $('#dropdowntypeend, #dropdownhourend').on('click', function() {
        var end = $('#dropdowntypeend :selected').text();
        var hourEnd = $('#dropdownhourend :selected').attr('value');
        var value = $('#dropdownhourend :selected').attr('value');
        var pm = 12;
        if ('PM' == end) {

            $('#dropdownhourend option:contains(00)').attr('disabled','disabled');
            if('00' == hourEnd)
            {
                $('#dropdownhourend option:contains(01)').attr('selected','selected')
            }
            var selectedHour = parseInt($('#dropdownhourend :selected').text()) + pm;
            if(24 == selectedHour)
            {
                selectedHour = '12';
            }
            $('#dropdownhourend :selected').attr('value', selectedHour);
            $('#dropdownhourend option:contains(12)').removeAttr('disabled');
        }
        if('AM' == end)
        {
            if( 12 <= value )
            {
                var selectedHour = parseInt(hourEnd) - pm;
            }
            $('#dropdownhourend :selected').attr('value', selectedHour);
            $('#dropdownhourend option[value="00"]').removeAttr('disabled');
            $('#dropdownhourend option:contains(12)').attr('disabled','disabled');
            if('12' == hourEnd)
            {
                $('#dropdownhourend option:contains(11)').attr('selected','selected')
            }
        }
    })
}

function setMaxDuration()
{
    $('#weekly').on('click', function() {
        $('#duration').attr('max', '4');
    });
    $('#bi-weekly').on('click', function() {
        $('#duration').attr('max', '2');
        });
    $('#monthly').on('click', function() {
        $('#duration').attr('max', '1');
    });
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function addEvent() {
    $.ajax({
        url: '/Event/add/',
        method: 'POST',
        data: $("#modal").serialize()
    }).then(function(data){
        console.log(data);
        if(data == true) {
            $('#myModal').modal('hide');
        }
    })
}