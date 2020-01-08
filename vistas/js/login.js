$(document).ready(function (){
    $('.element1').mousedown(function(){
        $('#password').removeAttr('type');
        $('#show').addClass('fa-unlock-alt').removeClass('fa-lock');
        document.getElementById('try').style.background = '#555555';
        document.getElementById('try').style.color = '#ffffff';
    });

   $('.element1').mouseup(function(){
        $('#password').attr('type','password');
        $('#show').addClass('fa-lock').removeClass('fa-unlock-alt');
        document.getElementById('try').style.background = '#ffffff';
        document.getElementById('try').style.color = '#555555';

    });
});