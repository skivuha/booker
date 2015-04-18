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
        setValueStartHour();
        setValueEndHour();
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
        setMaxDuration()
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
        $('option[value="'+selectedDay+'"]').attr('selected','selected');
    });
}

function setValueStartHour()
{
    $('#dropdowntypestart').on('click', function() {
        var start = $('#dropdowntypestart :selected').text();

        if('PM' == start)
        {   var pm = 12;
            var selectedHour = parseInt($('#dropdownhourstart :selected').text()) + pm;
            $('#dropdownhourstart :selected').attr('value', selectedHour);
        }
    })
}
function setValueEndHour() {
    $('#dropdowntypeend').on('click', function() {
        var end = $('#dropdowntypeend :selected').text();
        if ('PM' == end) {
            var pm = 12;
            var selectedHour = parseInt($('#dropdownhourend :selected').text()) + pm;
            $('#dropdownhourend :selected').attr('value', selectedHour);
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