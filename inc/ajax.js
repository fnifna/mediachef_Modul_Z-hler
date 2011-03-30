// JavaScript Document


// KALENDER
jQuery(function($){
        $.datepicker.regional['de'] = {clearText: 'enternen', clearStatus: 'Auswahl löschen',
                closeText: 'schließen', closeStatus: 'Änderungen nicht übernehmen',
                prevText: 'vorheriger Monat', prevStatus: 'vorheriger Monat',
                nextText: 'nächster Monat', nextStatus: 'nächster Monat',
                currentText: 'heute', currentStatus: '',
                monthNames: ['Januar','Februar','März','April','Mai','Juni',
                'Juli','August','September','Oktober','November','Dezember'],
                monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
                'Jul','Aug','Sep','Okt','Nov','Dez'],
                monthStatus: 'anderer Monat', yearStatus: 'anderes Jahr',
                weekHeader: 'Wo', weekStatus: 'Woche des Monats',
                dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
                dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayStatus: 'Setze DD als ersten Wochentag', dateStatus: 'Wähle D, M d',
                dateFormat: 'yy-mm-dd', firstDay: 1, 
                initStatus: 'Bitte wählen Sie ein Datum', isRTL: false};
        $.datepicker.setDefaults($.datepicker.regional['de']);
});
$(function() {
		$("#anz_bis").datepicker();
	});


// Publikation
$(document).ready(function() {
    $(".status").each(function(){
        $(this).click(function() {
            var key = $(this).attr('rel');
            $.ajax({
                url:'public.php',
                data: 'key='+key,
                dataType: 'html',
                success: function(result) {
                    if(result == "show") {
						$('#img_'+key).attr('src', 'img/public.png');
					} else if(result == 'dont_show') {
                        $('#img_'+key).attr('src', 'img/unpublic.png');
                    } else {
                        // error
                    }
					$('#ticker').load('ticker.php');
                }
            });
        });
    });
});  

// Calenderswitch
// Calenderswitch
$(document).ready(function() {
	$('#nextmonth').die('click');					   
   	$("#nextmonth").live('click',function() {
		var timestamp =  $("#nextmonth").attr('rel');
        $('#cal').load("cal.php?timestamp="+timestamp);
    });
	
	$('#lastmonth').die('click');					   
   	$("#lastmonth").live('click',function() {
		var timestamp =  $("#lastmonth").attr('rel');
    	$('#cal').load("cal.php?timestamp="+timestamp);
    });
	
}); 


// Temperatur
$(document).ready(function() {
	$(".pfeil_up_kuehlhaus").click(function(){
		var value = $("#kuehlhaus").html();
		var newValue = parseInt(value)+ 1;
		$("#kuehlhaus").html(newValue);
	});		
	$(".pfeil_down_kuehlhaus").click(function(){
		var value = $("#kuehlhaus").html();
		var newValue = parseInt(value)- 1;
		$("#kuehlhaus").html(newValue);
	});	
	
	$(".pfeil_up_kuehlschrank").click(function(){
		var value = $("#kuehlschrank").html();
		var newValue = parseInt(value)+ 1;
		$("#kuehlschrank").html(newValue);
	});		
	$(".pfeil_down_kuehlschrank").click(function(){
		var value = $("#kuehlschrank").html();
		var newValue = parseInt(value)- 1;
		$("#kuehlschrank").html(newValue);
	});	
	
	$(".pfeil_up_haus1").click(function(){
		var value = $("#haus1").html();
		var newValue = parseInt(value)+ 1;
		$("#haus1").html(newValue);
	});		
	$(".pfeil_down_haus1").click(function(){
		var value = $("#haus1").html();
		var newValue = parseInt(value)- 1;
		$("#haus1").html(newValue);
	});	
	
	$(".pfeil_up_haus2").click(function(){
		var value = $("#haus2").html();
		var newValue = parseInt(value)+ 1;
		$("#haus2").html(newValue);
	});		
	$(".pfeil_down_haus2").click(function(){
		var value = $("#haus2").html();
		var newValue = parseInt(value)- 1;
		$("#haus2").html(newValue);
	});	
	
	$(".pfeil_up_haus3").click(function(){
		var value = $("#haus3").html();
		var newValue = parseInt(value)+ 1;
		$("#haus3").html(newValue);
	});		
	$(".pfeil_down_haus3").click(function(){
		var value = $("#haus3").html();
		var newValue = parseInt(value)- 1;
		$("#haus3").html(newValue);
	});	
});

