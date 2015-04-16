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
            window.open('/Employee/index/', 'Appointment', 'location, width = 300px,' +
            'height = 300px, top = '+height+'px, left = '+widht+'px').focus();
        })
    }
);