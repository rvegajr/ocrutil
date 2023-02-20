jQuery(document).ready(function() {
	if(window.location.href.split('admin/')[1] == "product"){
		$('input#search_inp').quicksearch2('tr.customerRow', {'stripeRows': ['odd', 'even']});
	}
	else{
		$('input#search_inp').quicksearch('tr.customerRow', {'stripeRows': ['odd', 'even']});
	}
	if(window.location.href.split('new/')[1] == "Admin/product"){
		
		pop_table1();
		
		var $serialize = $( "#ptable" ).sortable({
			axis: 'y', 
			cursor: 'move',
			update: function(event, ui) {
				$.post(URLPath+"index.php/admin/saveorder",$serialize.sortable( "serialize",{"attribute":'dataid'}));
				$('input#search_inp').quicksearch2('tr.customerRow', {'stripeRows': ['odd', 'even']});
			}
		});
		
		$( "#ptable" ).disableSelection();
	}
	if(window.location.href.split('new/')[1] == "orderentry"){
		$.getJSON(URLPath+"index.php/admin/get_lists/"+$('#post_id').val(),{ajax: 'true'}, function(j){
	      var options = '';
	      var sel = '';
	      for (var i = 0; i < j.length; i++) {
	      	if(j[i].optionValue != "default"){
	      		if(i == 0){
	      			sel=' selected="selected"';
	      		}
	      		else{
	      			sel='';
	      		}
	        	options += '<option value="' + j[i].optionValue + '"'+sel+'>' + j[i].optionValue + '</option>';
	      	}
	      }
	      $("select#lists_opt").html(options);
	      if(i > 1){
			$(".list_opt_element").show();
	      	pop_table();
	      }
	      else{
			$(".list_opt_element").hide();
	      }
	    });
	}
	$('#datepicker').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		showTrigger: '#callImg'
	});
	$('#datepicker2').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		showTrigger: '#callImg'
	});
	$('#datepicker3').datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		showTrigger: '#callImg'
	});
	$('#ui-datepicker-div').css("display","none");
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		unique: true,
		persist: "cookie",
		toggle: function() {
			window.console && console.log("%o was toggled", this);
		}
	});
	
	// Navigation menu
	$('.customerRow td').dblclick(function() {
//		$('#myMenu').css('display','block');
//	 	window.location.href = $('.edit a').attr('href');
//	 	$('.edit').css('class', 'edit hover');
//	 	$('li.hover a').click();
	});
	jQuery('ul#navigation').superfish({ 
		delay:       1000,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast',
		autoArrows:  true,
		dropShadows: false
	});

	jQuery('ul#navigation li').hover(function(){
		jQuery(this).addClass('sfHover2');
	},
	function(){
		jQuery(this).removeClass('sfHover2');
	});
	
	// Live Search
	
	jQuery('#search-bar input[name="q"]').liveSearch({url: 'live_search.php?q='});
	
	//Hover states on the static widgets

	jQuery('.ui-state-default').hover(
		function() { jQuery(this).addClass('ui-state-hover'); }, 
		function() { jQuery(this).removeClass('ui-state-hover'); }
	);

	//Sortable portlets
//
//	jQuery('.sortable .column').sortable({
//		cursor: 'move',
//		connectWith: '.sortable .column',
//	});
//
//	jQuery(".column").disableSelection();
//
//	//Sidebar only sortable boxes
//	jQuery(".side_sort").sortable({
//		axis: 'y',
//		cursor: "move",
//		connectWith: '.side_sort'
//	});

	
	//Close/Open portlets
	jQuery(".portlet-header").hover(function() {
		jQuery(this).addClass("ui-portlet-hover");
	},
	function(){
		jQuery(this).removeClass("ui-portlet-hover");
	});

	jQuery(".portlet-header .ui-icon").click(function() {
		jQuery(this).toggleClass("ui-icon-circle-arrow-n");
		jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
	});


	// Sidebar close/open (with cookies)

	function close_sidebar() {
		
		jQuery("#sidebar").addClass('closed-sidebar');
		jQuery("#page_wrapper #page-content #page-content-wrapper").addClass("no-bg-image wrapper-full");
		jQuery("#open_sidebar").show();
		jQuery("#close_sidebar, .hide_sidebar").hide();
	}

	function open_sidebar() {
		jQuery("#sidebar").removeClass('closed-sidebar');
		jQuery("#page_wrapper #page-content #page-content-wrapper").removeClass("no-bg-image wrapper-full");
		jQuery("#open_sidebar").hide();
		jQuery("#close_sidebar, .hide_sidebar").show();
	}

	jQuery('#close_sidebar').click(function(){
		close_sidebar();
		if(jQuery.browser.safari) {
		    location.reload();
		}
		jQuery.cookie('sidebar', 'closed' );
			jQuery(this).addClass("active");
	});
	
	jQuery('#open_sidebar').click(function(){
		open_sidebar();
		if(jQuery.browser.safari) {
		    location.reload();
		}
		jQuery.cookie('sidebar', 'open' );
	});
	
	var sidebar = jQuery.cookie('sidebar');

		if (sidebar == 'closed') {
			close_sidebar();
	    };

		if (sidebar == 'open') {
			open_sidebar();
	    };

	/* Tooltip */

	jQuery(function() {
		jQuery('.tooltip').tooltip({
			track: true,
			delay: 0,
			showURL: false,
			showBody: " - ",
			fade: 250
			});
		});
		
	/* Theme changer - set cookie */

    jQuery(function() {

        jQuery('a.set_theme').click(function() {
           	var theme_name = jQuery(this).attr("id");
			jQuery('body').append('<div id="theme_switcher" />');
			jQuery('#theme_switcher').fadeIn('fast');

			setTimeout(function () { 
				jQuery('#theme_switcher').fadeOut('fast');
			}, 2000);

			setTimeout(function () { 
			jQuery("link[title='style']").attr("href","css/themes/" + theme_name + "/ui.css");
			}, 500);

			jQuery.cookie('theme', theme_name );

			jQuery('a.set_theme').removeClass("active");
			jQuery(this).addClass("active");
			
        });
		
		var theme = jQuery.cookie('theme');

		jQuery("a.set_theme[id="+ theme +"]").addClass("active");
	    
		if (theme == 'black_rose') {
	        jQuery("link[title='style']").attr("href","css/themes/black_rose/ui.css");
	        
	    };

		if (theme == 'gray_standard') {
	        jQuery("link[title='style']").attr("href","css/themes/gray_standard/ui.css");
	    };

		if (theme == 'gray_lightness') {
	        jQuery("link[title='style']").attr("href","css/themes/gray_lightness/ui.css");
	    };
	    
		if (theme == 'blueberry') {
	        jQuery("link[title='style']").attr("href","css/themes/blueberry/ui.css");
	    };
	    
		if (theme == 'apple_pie') {
	        jQuery("link[title='style']").attr("href","css/themes/apple_pie/ui.css");
	    };

    });
    
	/* Layout option - Change layout from fluid to fixed with set cookie */

    jQuery(function() {

		jQuery('.layout-options a').click(function(){
			var lay_id = jQuery(this).attr("id");
			jQuery('body').attr("class",lay_id);
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
			jQuery.cookie('layout', lay_id );
			jQuery('.layout-options a').removeClass("active");
			jQuery(this).addClass("active");
		})
			
	    var lay_cookie = jQuery.cookie('layout');

		jQuery(".layout-options a[id="+ lay_cookie +"]").addClass("active");

		if (lay_cookie == 'layout100') {
			jQuery('body').attr("class","");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").removeClass("fixed");
	    };

		if (lay_cookie == 'layout90') {
			jQuery('body').attr("class","layout90");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };
	    
		if (lay_cookie == 'layout75') {
			jQuery('body').attr("class","layout75");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };
	    
		if (lay_cookie == 'layout980') {
			jQuery('body').attr("class","layout980");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };
	    
		if (lay_cookie == 'layout1280') {
			jQuery('body').attr("class","layout1280");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };
	    
		if (lay_cookie == 'layout1400') {
			jQuery('body').attr("class","layout1400");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };
	    
		if (lay_cookie == 'layout1600') {
			jQuery('body').attr("class","layout1600");
			jQuery("#page-layout, #page-header-wrapper, #sub-nav").addClass("fixed");
	    };

    });

	// Dialog			

	jQuery('#dialog').dialog({
		autoOpen: false,
		width: 600,
		bgiframe: false,
		modal: false,
		buttons: {
			"Ok": function() { 
				jQuery(this).dialog("close"); 
			}, 
			"Cancel": function() { 
				jQuery(this).dialog("close"); 
			} 
		}
	});

	// Modal Confirmation		

		jQuery("#modal_confirmation").dialog({
			autoOpen: false,
			bgiframe: true,
			resizable: false,
			width:500,
			modal: true,
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete all items in recycle bin': function() {
					jQuery(this).dialog('close');
				},
				Cancel: function() {
					jQuery(this).dialog('close');
				}
			}
		});

	// Dialog Link

	jQuery('#dialog_link').click(function(){
		jQuery('#dialog').dialog('open');
		return false;
	});
	
	// Modal Confirmation Link

	jQuery('#modal_confirmation_link').click(function(){
		jQuery('#modal_confirmation').dialog('open');
		return false;
	});
	
	// Same height

	var sidebarHeight = jQuery("#sidebar").height();
	jQuery("#page-content-wrapper").css({"minHeight" : sidebarHeight });

	// Simple drop down menu

	var myIndex, myMenu, position, space=20;
	
	jQuery("div.sub").each(function(){
		jQuery(this).css('left', jQuery(this).parent().offset().left);
		jQuery(this).slideUp('fast');
	});
	
	jQuery(".drop-down li").hover(function(){
		jQuery("ul",this).slideDown('fast');
		
		//get the index, set the selector, add class
		myIndex = jQuery(".main1").index(this);
		myMenu = jQuery(".drop-down a.btn:eq("+myIndex+")");
	}, function(){
		jQuery("ul",this).slideUp('fast');
	});

/*
jQuery('.fg-button').hover(
 function(){ jQuery(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
 function(){ jQuery(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
 );
*/
 // MENU
table_fix();
//select all the a tag with name equal to modal
$('a[name=modal]').click(function(e) {
	//Cancel the link behavior
	e.preventDefault();
	
	//Get the A tag
	var id = $(this).attr('href');

	//Get the screen height and width
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();

	//Set heigth and width to mask to fill up the whole screen
	$('#mask').css({'width':maskWidth,'height':maskHeight});
	
	//transition effect		
	$('#mask').fadeIn(1000);	
	$('#mask').fadeTo("slow",0.8);	

	//Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();
          
	//Set the popup window to center
	$(id).css('top',  winH/2-$(id).height()/2);
	$(id).css('left', winW/2-$(id).width()/2);

	//transition effect
	$(id).fadeIn(2000);

});

//if close button is clicked
$('.window .close').click(function (e) {
	//Cancel the link behavior
	e.preventDefault();
	
	$('#mask').hide();
	$('.window').hide();
});		

//if mask is clicked
$('#mask').click(function () {
	$(this).hide();
	$('.window').hide();
});			

$(window).resize(function () {
 
		var box = $('#boxes .window');

    //Get the screen height and width
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();
  
    //Set height and width to mask to fill up the whole screen
    $('#mask').css({'width':maskWidth,'height':maskHeight});
           
    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();

    //Set the popup window to center
    box.css('top',  winH/2 - box.height()/2);
    box.css('left', winW/2 - box.width()/2);
 
});
 
 
$('.caname').dblclick(function() {
  $('.caname').trigger({type:'mousedown',button:2}).trigger({type:'mouseup'});
  $('#ecamp').trigger('click');
});

$('.coname').dblclick(function() {
  $('.coname').trigger({type:'mousedown',button:2}).trigger({type:'mouseup'});
  $('#ecomp').trigger('click');
});
$(".caname").attr('class', 'ca');
$(".coname").attr('class', 'co');
	
$("#res_table").tablesorter(); 
	
});

$(window).resize(function() {
  table_fix();
});

function table_fix(){
	// $('#prostotiq').css('width',$(window).width()-350);
	//$('#order_entry_table').css('height',$(window).height()-80);
}
function redirect(addr){
	window.location.assign(addr);
	//window.location.href = addr;
}

function check_qty(row){
	
	/*
	var count = 0;
	if($('#s_'+row).val().match('^(0|[1-9][0-9]*)$')){
		count += parseInt($('#s_'+row).val());
	}
	if($('#m_'+row).val().match('^(0|[1-9][0-9]*)$')){
		count += parseInt($('#m_'+row).val());
	}
	if($('#l_'+row).val().match('^(0|[1-9][0-9]*)$')){
		count += parseInt($('#l_'+row).val());
	}
	if($('#xl_'+row).val().match('^(0|[1-9][0-9]*)$')){
		count += parseInt($('#xl_'+row).val());
	}
	if($('#xxl_'+row).val().match('^(0|[1-9][0-9]*)$')){
		count += parseInt($('#xxl_'+row).val());
	}
	$('#qty_'+row).val(count);
	var price = $('#cost_'+row).val();
	$('#total_'+row).text('$'+count*price);
	$('#totalh_'+row).val(count*price);
	var i=0;
	var sub_total = 0;
	var sub_qty = 0;
	while(i<parseInt($('#cnt').val())){
		if($('#totalh_'+i).val() != 0){
			sub_total += parseFloat($('#totalh_'+i).val());
			
		}
		if($('#qty_'+i).val().match('^(0|[1-9][0-9]*)$')){
			sub_qty += parseInt($('#qty_'+i).val());
		}
		i++;
	}
	$('#sub_total').text('$'+sub_total.toFixed(2));
	$('#floating_st').text('$'+sub_total.toFixed(2));
	$('#sub_qty').text(sub_qty);
	$('#floating_q').text(sub_qty);
	var sub_total_incl_tax = sub_total;
	var sub_total_disc = 0;
	if(sub_total_incl_tax > 0){
		var sub_total_disc_am = sub_total_incl_tax-parseFloat($('#disc_inp').val());
		var sub_total_disc_p = sub_total_incl_tax-(sub_total_incl_tax*parseFloat($('#disc_inp').val())/100);
	}
	else{
		var sub_total_disc_am = 0;
		var sub_total_disc_p = 0;
	}
	switch(parseInt($('#selected').val())){
		case 1:
			sub_total_disc = sub_total_disc_am.toFixed(2);
			break;
		case 2:
			sub_total_disc = sub_total_disc_p.toFixed(2);
			break;
		default:
			break;
	}
	$('#sub_total_disc').text('$'+sub_total_disc);
	$('#order_total').val('$'+sub_total_disc);
	$('#floating_ot').text('$'+sub_total_disc);
	$('#prices').val(sub_total_disc);
	*/
}

function price_edit(str){
	var type=parseInt(str);
	var tax_price = parseFloat($('#sub_total').text().split("$")[1]);
	switch(type){
		case 1:
			if($('#disc_inp').val().match('^(0|[1-9][0-9]*)$') && $('#disc_inp').val() > -1){
				if($('#disc_inp').val() == 0){
					price = tax_price;
				}
				else{
					price = tax_price-parseFloat($('#disc_inp').val());
				}
				console.log(price);
			}
			break;
		case 2:
			if($('#disc_inp').val().match('^(0|[1-9][0-9]*)$') && $('#disc_inp').val() > -1 && $('#disc_inp').val() < 101){
				if($('#disc_inp').val() == 0){
					percent = 0;
					price = tax_price;
				}
				else{
					percent = tax_price*parseFloat($('#disc_inp').val())/100;
					price = tax_price-percent;
				}
				console.log(price);
			}
			break;
		default:
			break;
	}
	if(tax_price > 0 && tax_price >= price && price >= 0){
		clprice = price.toFixed(2);
		$('#sub_total_disc').text('$'+clprice);
		$('#order_total').val('$'+clprice);
		$('#floating_ot').text('$'+clprice);
		$('#prices').val(clprice);
	}
	$('#selected').val(type);
}

function check_value(){
	if($('#disc_inp').val() == ""){
		$('#disc_inp').val(0)
	}
}

function show_add_new(){
	$("#new_pass").hide();
	$("#add_new").show();
}

function hide_add_new(){
	$("#add_new").hide('');
}

function show_add_new_prod(){
	$("#add_new").show();
}

function hide_add_new_prod(){
	$("#add_new").hide('');
}

function hide_add_new_opts(){
	var i=0;
	while(i<parseInt($("#fc0").val())){
		$("#minus5").trigger('click');
		i++;
	}
	$("#add_new").hide('');
}

function show_new_pass(){
	$("#add_new").hide();
	$("#new_pass").show();
}

function hide_new_pass(){
	$("#new_pass").hide();
}

function check_fields_user(){
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($('#username').val().length < 3){
		alert('Username must be more than 3 characters in length');
		$('#username').focus();
	}
	else if($('#email').val().length < 5 || reg.test($('#email').val()) == false){
		alert('Enter valid email');
		$('#email').val('');
		$('#email').focus();
	}
	else if($('#f_name').val().length < 3){
		alert('First Name must be more than 2 characters in length');
		$('#f_name').val('');
		$('#f_name').focus();
	}
	else if($('#l_name').val().length < 3){
		alert('Last Name must be more than 2 characters in length');
		$('#l_name').val('');
		$('#l_name').focus();
	}
	else if($('#pass1').val().length < 6){
		alert('Password must be more than 6 characters in length');
		$('#pass1').val('');
		$('#pass1').focus();
	}
	else if($('#pass2').val().length < 6){
		alert('Password must be more than 6 characters in length');
		$('#pass2').val('');
		$('#pass2').focus();
	}
	else if($('#pass1').val() != $('#pass2').val()){
		alert('Passwords are different');
		$('#pass1').val('');
		$('#pass2').val('');
		$('#pass1').focus();
	}
	else{
		document.add_edit.submit();
	}
}

function check_fields_pass(){
	if($('#newpass1').val().length < 6){
		alert('Password must be more than 6 characters in length');
		$('#newpass1').val('');
		$('#newpass1').focus();
	}
	else if($('#newpass2').val().length < 6){
		alert('Password must be more than 6 characters in length');
		$('#newpass2').val('');
		$('#newpass2').focus();
	}
	else if($('#newpass1').val() != $('#newpass2').val()){
		alert('Passwords are different');
		$('#newpass1').val('');
		$('#newpass2').val('');
		$('#newpass1').focus();
	}
	else{
		document.chpass.submit();
	}
}

function check_fields_vendor(){
	if($('#vendor').val().length < 3){
		alert('Vendor name must be more than 3 characters in length');
		$('#vendor').focus();
	}
	else if($('#first_contact').val().length < 3){
		alert('First Name must be more than 3 characters in length');
		$('#first_contact').val('');
		$('#first_contact').focus();
	}
	else if($('#last_contact').val().length < 3){
		alert('Last Name must be more than 3 characters in length');
		$('#last_contact').val('');
		$('#last_contact').focus();
	}
	else if($('#address').val().length < 3){
		alert('Address must be more than 3 characters in length');
		$('#address').val('');
		$('#address').focus();
	}
	else if($('#city_sz').val().length < 2){
		alert('City Name must be more than 2 characters in length');
		$('#city_sz').val('');
		$('#city_sz').focus();
	}
	else if($('#post').val().length < 3){
		alert('Post Code must be more than 3 characters in length');
		$('#post').val('');
		$('#post').focus();
	}
	else{
		document.add_edit.submit();
	}
}

function check_fields_post(){
	if($('#post').val().length < 3){
		alert('Post name must be more than 3 characters in length');
		$('#post').focus();
	}
	else if($('#address').val().length < 3){
		alert('Address must be more than 3 characters in length');
		$('#address').val('');
		$('#address').focus();
	}
	else if($('#city_sz').val().length < 2){
		alert('City Name must be more than 2 characters in length');
		$('#city_sz').val('');
		$('#city_sz').focus();
	}
	else if($('#post').val().length < 3){
		alert('Post Code must be more than 3 characters in length');
		$('#post').val('');
		$('#post').focus();
	}
	else{
		document.add_edit.submit();
	}
}

function check_fields_co(){
	if($('#companyn').val().length < 3){
		alert('Company Name must be more than 3 characters in length');
		$('#companyn').val('');
		$('#companyn').focus();
	}
	else if($('#companyc').val().length < 2){
		alert('Company Code must be more than 2 characters in length');
		$('#companyc').val('');
		$('#companyc').focus();
	}
	else{
		document.add_edit_co.submit();
	}
}

function check_fields_ca(){
	if($('#cac').val().length < 2){
		alert('Campaign Code must be more than 2 characters in length');
		$('#cac').val('');
		$('#cac').focus();
	}
	else if($('#tdate').val() == ""){
		alert('Select Target Date');
		$('#tdate').focus();
	}
	else if($('#sdate').val() == ""){
		alert('Select Submitted Date');
		$('#sdate').focus();
	}
	else if($('#poc').val().length < 2){
		alert('PO Code must be more than 2 characters in length');
		$('#poc').val('');
		$('#poc').focus();
	}
	else if($('#pdate').val() == ""){
		alert('Select PO Date');
		$('#pdate').focus();
	}
	else{
		document.add_edit_ca.submit();
	}
}

function check_fields_pt(){
	if($('#pname').val().length < 3){
		alert('Platoon Name must be more than 3 characters in length');
		$('#pname').val('');
		$('#pname').focus();
	}
	else if($('#jn').val().length < 2){
		alert('Job Number must be more than 2 characters in length');
		$('#jn').val('');
		$('#jn').focus();
	}
	else{
		document.add_edit_pt.submit();
	}
}

function check_fields_sol(){
	if($('#fname').val().length < 3){
		alert('First name must be more than 3 characters in length');
		$('#fname').focus();
	}
	else if($('#address').val().length < 3){
		alert('Address must be more than 3 characters in length');
		$('#address').val('');
		$('#address').focus();
	}
	else if($('#city_sz').val().length < 2){
		alert('City Name must be more than 2 characters in length');
		$('#city_sz').val('');
		$('#city_sz').focus();
	}
	else if($('#postc').val().length < 3){
		alert('Post Code must be more than 3 characters in length');
		$('#postc').val('');
		$('#postc').focus();
	}
	else{
		document.add_edit_sol.submit();
	}
}

function downloadfile(str, id){
	alert(str +' yeah '+id);
}

function showimage(base,id,cid){
	$('#new_pic').hide();
	$('#image_field').show();
	$('#image_field').html('<img src="'+base+'/cache/art/'+cid+'/'+id+'" width="400">');
}

function get_the_menu(id){
	var i=1;
	while(i<5){
		$('ul.menu'+i).attr("id","myMenu"+i);
		i++;
	}
	$('ul.menu'+id).attr("id","myMenu");
}

function get_the_menu2(id){
	var i=1;
	while(i<3){
		$('ul.menu'+i).attr("id","myMenu"+i);
		i++;
	}
	$('ul.menu'+id).attr("id","myMenu");
}

function add_new_company(){
	$('#add_new_ca').hide();
	$('#add_new_pt').hide();
	$('#add_new_sol').hide();
	$('#add_new_co').show();
}

function add_new_coh(){
	$('#add_new_co').hide();
}

function add_new_campaign(){
	$('#add_new_pt').hide();
	$('#add_new_co').hide();
	$('#add_new_sol').hide();
	$('#add_new_ca').show();
}

function add_new_cah(){
	$('#add_new_ca').hide();
}

function add_new_pt(){
	$('#add_new_ca').hide();
	$('#add_new_co').hide();
	$('#add_new_sol').hide();
	$('#add_new_pt').show();
}

function add_new_pth(){
	$('#add_new_pt').hide();
}

function add_new_sol(){
	$('#add_new_ca').hide();
	$('#add_new_co').hide();
	$('#add_new_pt').hide();
	$('#add_new_sol').show();
	
}

function add_new_solh(){
	$('#add_new_sol').hide();
}

$(function(){
	$("select#postca").change(function(){
    $.getJSON(URLPath+"index.php/admin/get_companies/"+$(this).val(),{ajax: 'true'}, function(j){
      var options = '';
      if (j) {
    	  for (var i = 0; i < j.length; i++) {
    		  options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
    	  }
      }
      $("select#comca").html(options);
    })
  })
})

function dollar(){
		$('#costd').keyup(function () { 
		    this.value = this.value.replace(/[^0-9\.]/g,'');
		});
}

function setCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    return str.substr(0,index) + chr + str.substr(index+1);
}

function pop_table(){
	$('tr.customerRow').each(function(index) {
	   if($('#post_id').val() == $(this).find('td#poid').text() && $('#lists_opt').val() == $(this).find('td#list').text()){
	   		$(this).css('display','block')
	   		$(this).css('display', '');
	   }
	   else{
	   		$(this).css('display', 'none');
	   }
	});
	$('input#search_inp').quicksearch2('tr.customerRow', {'stripeRows': ['odd', 'even']});
}

function pop_table1(){
	$.getJSON(URLPath+"index.php/admin/get_lists/"+$('#posts_all').val(),{ajax: 'true'}, function(j){
      var options = '';
      var sel = '';
      for (var i = 0; i < j.length; i++) {
      		if(i == 0){
      			sel=' selected="selected"';
      		}
      		else{
      			sel='';
      		}
        	options += '<option value="' + j[i].optionValue + '"'+sel+'>' + j[i].optionValue + '</option>';
      	}
      $("select#lw_opts").html(options);
      if(i > 1){
      	$("select#lw_opts").show();
      	pop_table2();
      }
      else{
      	$("select#lw_opts").hide();
      	$('#list_opts').val('default');
      }
    })
	$('#search_inp').val(' ');
	$('tr.customerRow').each(function(index) {
	   if($('#posts_all').val() != $(this).attr('id')){
	   		$(this).css('display', 'none');
	   }
	   else{
	   		$(this).css('display', '');
	   }
	});
	$('input#search_inp').quicksearch2('tr.customerRow', {'stripeRows': ['odd', 'even']});
}

function pop_table2(){
	$('#list_opts').val($('#lw_opts').val());
	$('tr.customerRow').each(function(index) {
	   if($('#posts_all').val() == $(this).attr('id') && $('#lw_opts').val() == $(this).find('td#list').text()){
	   		$(this).css('display', '');
	   }
	   else{
	   		$(this).css('display', 'none');
	   }
	});
	$('input#search_inp').quicksearch2('tr.customerRow', {'stripeRows': ['odd', 'even']});
}

function get_pts(){
	$.getJSON(URLPath+"index.php/admin/get_pt/"+$('#opts').val(),{ajax: 'true'}, function(l){
      	var options = '';
      	for (var i = 0; i < l.length; i++) {
        	options += '<option value="' + l[i].optionValue + '">' + l[i].optionDisplay + '</option>';
      	}
    	$("#codes").html(options);
    })
}

function get_posts_list(id){
	if($('#posts_list').css('display') == "none"){
		$.getJSON(URLPath+"index.php/admin/get_posts/"+id,{ajax: 'true'}, function(l){
	      	var options = '';
	      	for (var i = 0; i < l.length; i++) {
	        	options += '<li class="insert" onmouseover="$(this).attr(\'class\', $(this).attr(\'class\')+\' hover\');" onmouseout="$(this).attr(\'class\',\'insert\');" onclick="copy_list_to_post('+l[i].id+',\'' + l[i].post_name + '\');"><a href="#">' + l[i].post_name + '</a></li>';
	      	}
	    	$("#posts_list").html(options);
	    })
		$('#posts_list').show('slow');
	}
}

function copy_list_to_post(id,name){
	var msg = "Are you sure you want to copy "+$('#lw_opts').val()+" list to "+name+"?";
	var x=window.confirm(msg)
	if (x){
		$.post(URLPath+"index.php/admin/copylist",{from_post: $('#posts_all').val(), list: $('#lw_opts').val(), to_post: id});
	}
}

function get_list(id){
	$.getJSON(URLPath+"ordersearch/get_list/"+id,{ajax: 'true'}, function(j){
	      var tds = '';
	      var cnt = 0;
	      var cnt2 = 0;
	      var filled = [];
	      for (var i = 0; i < j.length; i++) {
				cnt++;
	        	tds += '<tr class="customerRow"><td style="display: none;"><input type="hidden" name="cost_'+i+'"  id="cost_'+i+'" value="'+j[i].unit_price+'"></td><td id="productcode"><input type="hidden" name="p_id_'+i+'" value="'+j[i].product_id+'"><input type="hidden" name="p_code_'+i+'" value="'+j[i].product_code+'">'+j[i].product_code+'</td><td id="logname">'+j[i].product_code+'</td><td id="list" style="display: none;">'+j[i].product_code+'</td><td id="poid" style="display: none;">'+j[i].product_code+'</td><td id="cost">$'+j[i].unit_price+'</td><td class="notes"><input type="text" name="notes_'+i+'" autocomplete="off"></td><td><input type="text" id="s_'+i+'" name="s_'+i+'" onkeyup="check_qty('+i+');" autocomplete="off" value="'+j[i].s+'"></td><td><input type="text" id="m_'+i+'" name="m_'+i+'" onkeyup="check_qty('+i+');" autocomplete="off" value="'+j[i].m+'"></td><td><input type="text" id="l_'+i+'" name="l_'+i+'" onkeyup="check_qty('+i+');" autocomplete="off" value="'+j[i].l+'"></td><td><input type="text" id="xl_'+i+'" name="xl_'+i+'" onkeyup="check_qty('+i+');" autocomplete="off" value="'+j[i].xl+'"></td><td><input type="text" id="xxl_'+i+'" name="xxl_'+i+'" onkeyup="check_qty('+i+');" autocomplete="off" value="'+j[i].xxl+'"></td><td><input style="border:1px solid #ccc; background-color: #fff" type="text" id="qty_'+i+'" name="qty_'+i+'" autocomplete="off" onkeyup="check_qty('+i+');" value="'+j[i].quantity+'"></td><td id="total_'+i+'">$0</td><td style="display: none;"><input type="hidden" name="totalh_'+i+'" id="totalh_'+i+'" value="0"></td></tr>';
	      		if(j[i].s > 0 || j[i].m > 0 || j[i].l > 0 || j[i].xl > 0 || j[i].xxl > 0){
	      			filled[cnt2] = i;
	      			cnt2++;
	      		}
	      }
	      console.log(filled);
	      tds += ' <tr><td style="display:none;"><input type="hidden" id="cnt" name="p_count" value="'+cnt+'"></td><td colspan="10" style="border: none !important; text-align: right; background: none; background-color: #F2F2F2">Quantity / Sub Total</td><td id="sub_qty" style="border: none !important; text-align: center; background: none; background-color: #F2F2F2">0</td><td id="sub_total" style="border: none !important; background: none; background-color: #F2F2F2">$0</td></tr><tr><td colspan="8" style="border: none !important; text-align: right; background: none; background-color: #F2F2F2"><input type="radio" name="disc" id="disc" value="1" onclick="price_edit(1);" checked>Amount <input type="radio" name="disc" id="disc" value="2" onclick="price_edit(2);">Percent<input type="hidden" id="selected" name="selected_disc" value="1"></td><td colspan="2" style="border: none !important; text-align: right; background: none; background-color: #F2F2F2">Discount</td><td style="border: none !important; text-align: center; background: none; background-color: #F2F2F2"><input type="text" name="disc" id="disc_inp" value="0" style="width: 30px" onkeyup="price_edit(getElementById(\'selected\').value);" onblur="check_value();"></td><td id="sub_total_disc" style="border: none !important; background: none; background-color: #F2F2F2">$0</td></tr><tr><td colspan="10" style="border: none !important; text-align: right; background: none; background-color: #F2F2F2">Order Total</td><td style="border: none !important; text-align: center; background: none; background-color: #F2F2F2"></td><td style="border: none !important; background: none; background-color: #F2F2F2; font-weight: bold;"><input type="text" id="order_total" value="$0" name="order_total" disabled style="border:none; background:none; width:60px;font-size: 11px; font-weight: bold;"></td></tr><tr><td colspan="12" style="border: none !important; text-align: right; background: none; background-color: #F2F2F2"><input type="submit" value="Save" style="width:60px;"></td></tr>';
	      $('#resultss').html(tds);
	      for (var j = 0; j < cnt2; j++){
	      	check_qty(filled[j]);
	      }
	      $('#update_id').val(id);
	      $('#dialog').height($('#cnt').val()*19);
	    });
}

function get_campaigns_posts(id){
	$.getJSON(URLPath+"data/lookups?lk=cycles_by_post&post_id="+id,{ajax: 'true'}, function(j){
		var options = '';
		if (j) {
			for (var i = 0; i < j.length; i++) {
	        	options += '<option value="' + j[i].id + '">' + j[i].campaign_code + '</option>';
			}
		}
		$("select#camp_home").html(options);
	});
}

function get_campaigns_cycles(post_id, controlsel){
	$(controlsel).html(options);
	$.getJSON(URLPath+"data/lookups?lk=cycles_by_post&post_id="+post_id,{ajax: 'true'}, function(j){
		var options = '';
		if (j) {
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].campaign_code + '</option>';
			}
		}
		$(controlsel).html(options);
	});
}
function change_the_price(){
	if($('input:radio[name=type_np]:checked').val()== 1){
		$('td[pr_id="'+$('#pr_id_new').val()+'"]').html('<input type="hidden" id="p_id_cp" value="'+$('#pr_id_new').val()+'">$'+$('#new_price').val());
		$('input[pr_new_c='+$('#pr_id_new').val()+']').val($('#new_price').val());
		$('.ui-icon.ui-icon-closethick').trigger('click');
	}
	if($('input:radio[name=type_np]:checked').val()== 2 || $('input:radio[name=type_np]:checked').val()== 3){
		document.change_price.submit();
	}
}

/*function correct_prices(id){
	$.getJSON(URLPath+"orderentry/corprcs/"+id,{ajax: 'true'}, function(j){
	      for (var i = 0; i < j.length; i++) {
				
	      }
	}
}*/