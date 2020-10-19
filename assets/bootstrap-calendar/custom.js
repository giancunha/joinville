

(function($) {
	"use strict";
    // date time picker
	function dateTimePickerAgenda(){
		var optionPicker = {
			toolbarPlacement:'top',
			sideBySide: true,
			showClear:true,
			locale: 'pt-br',
			showClose:true,
			useCurrent:false
		}
		$('#datetimepicker1').datetimepicker(optionPicker);
		//optionPicker.useCurrent = false; //Important! See issue #1075);
	    $('#datetimepicker2').datetimepicker(optionPicker);
	    $("#datetimepicker1").on("dp.change", function (e) {
	        $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
	    });
	    $("#datetimepicker1").on("dp.change", function (e) {
	        $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
	    });
	}

	dateTimePickerAgenda();

	var options = {
		language: 'pt-BR',
		//events_source: 'events.json.php',
		view: 'month',
		tmpl_path: '/assets/bootstrap-calendar/tmpls/',
		tmpl_cache: false,
		modal:"#events-modal",
		modal_type : "template", 
		modal_title : function (e) { return e.title },
		display_week_numbers:false,
		weekbox:false,
		onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function(view) {
			$('.page-header h3').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		},
        events_source: '/telas/agendas/agenda/getAgenda.php?type=calendar'
	};

	var calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});

	$('#first_day').change(function(){
		var value = $(this).val();
		value = value.length ? parseInt(value) : null;
		calendar.setOptions({first_day: value});
		calendar.view();
	});

	
	$('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
		//e.preventDefault();
		//e.stopPropagation();
	});

	$("#calendar").on("click", ".add_event_day",function(event){
		event.preventDefault();
		var data = $(this).data("date");

		alert(data);

	});
        
        $("#btnInfoCalendar").on("click",function(){
            var idEvento = $(this).parent().parent().find("#eventoCalendar").val();
            var url = $(this).data("url");
            if(idEvento){
                window.location = url+idEvento;
            }
        });
}(jQuery));

//cal-day-hour
