$(function() {
	$('#start_date').datepick({ 
	//	renderer: $.datepick.weekOfYearRenderer, 
		firstDay: 1, 
		showOtherMonths: true,
		dateFormat: 'yyyy-mm-dd', 
		selectDefaultDate: true,
//		onSelect: function(dates) {
//			var s_date = $('#start_date').val().split("-");
//			var start = new Date(s_date[0], (s_date[1] - 1), s_date[2]);
//			start.setDate(start.getDate()+6);														
//			$('#end_date').datepick('option',"minDate",start);
//			calcLength();
//			validate();
//			}
	});
	
	$('#end_date').datepick({
	//	renderer: $.datepick.weekOfYearRenderer, 
		firstDay: 1, 
		showOtherMonths: true, 
		rangeSelect: false, 
		selectOtherMonths: true,
	//	onShow: $.datepick.selectWeek, 
		dateFormat: 'yyyy-mm-dd', 
		selectDefaultDate: true,
//		onSelect: function(dates) {													
//			calcLength();
//			validate();
//			}
	});
	
	
	function calcLength(){
		var s_date = $('#start_date').val().split("-");
		var start = new Date(s_date[0], (s_date[1] - 1), s_date[2]);
			
		var e_date = $('#end_date').val().split("-");
		var end = new Date(e_date[0], (e_date[1] - 1), e_date[2]);
		
		var diff = (end.getTime() - start.getTime()) / 1000 / 86400;
	}
	
	function validate(){
		var s_date = $('#start_date').val().split("-");
		var start = new Date(s_date[0], (s_date[1] - 1), s_date[2]);
			
		var e_date = $('#end_date').val().split("-");
		var end = new Date(e_date[0], (e_date[1] - 1), e_date[2]);
		
		if(start.getTime() >= end.getTime()) {
			$('#start_date').datepick('setDate',+1);
			$('#end_date').datepick('setDate',+7*13-5);					
		}
	}
	
});