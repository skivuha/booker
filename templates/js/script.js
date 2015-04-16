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
        })
    }
);