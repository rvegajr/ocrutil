$(document).ready(function() {

        $("#addNewCustomerInstructionsImg").click(function(ev) {
            toggleAddCustomerInstructions();
        });

        $("#addNewCustomerInstructionsLink").click(function(ev) {
            ev.preventDefault();
            toggleAddCustomerInstructions();
        });

        $("#addNewCustomerInstructionsClose").click(function(ev) {
            ev.preventDefault();
            toggleAddCustomerInstructions();
        });

        $("#customerResponse").fadeOut(5000);

        $(".customerRow").contextMenu({ menu: 'myMenu' }, function(action, el, pos) { contextMenuWork(action, el, pos); });
        
        $(".openmenu").contextMenu({ menu: 'myMenu', leftButton: true }, function(action, el, pos) { contextMenuWork(action, el.parent("tr"), pos); });
    });
    
		function do_del(id, what){
			console.log(what+ ":" + id);
			$.getJSON("http://brumbo.net/new/delete/"+what+"/" + id);
			setTimeout("location.reload(true);", 500);
		}
					
        function contextMenuWork(action, el, pos) {

            switch (action) {
            	/*
            	
            	HERE IS THE START OF THE LOGIC FOR users PAGE!!!
            		
            	*/
                case "delete":
                    {
                        var msg = "Delete " + $(el).find("#contactfirst").text() + " " + $(el).find("#contactlast").text() + " (" + $(el).find("#contactname").text() +") ?";
						var x=window.confirm(msg)
						if (x){
							do_del($(el).find("#id").text(), "user");
						}
						break;
                    }
                case "insert":
                    {
                    	$("#add_new_title").html('Add New');
                    	$("#edit_id").val('0');
                       	show_add_new();
                        break;
                    }

                case "edit":
                    {
                    	var msg = "Edit " + $(el).find("#contactfirst").text() + " " + $(el).find("#contactlast").text() + " (" + $(el).find("#contactname").text() +")";
                    	$("#add_new_title").html(msg);
                        $("#username").val($(el).find("#contactname").text());
                        $("#email").val($(el).find("#contactemail").text());
                        $("#f_name").val($(el).find("#contactfirst").text());
                        $("#l_name").val($(el).find("#contactlast").text());
                        $("#edit_id").val($(el).find("#id").text());
                        $("#edit_user").val('1');
                        $("#edit_pass").val('0');
                        show_add_new();
                        break;
                    }
                case "chpass":
	                {	
	                	var msg = "Change Password for " + $(el).find("#contactfirst").text() + " " + $(el).find("#contactlast").text() + " (" + $(el).find("#contactname").text() +")";
                    	$("#add_new_title_pass").html(msg);
                    	$("#edit_id2").val($(el).find("#id").text());
	                	$("#edit_user").val('0');
	                	$("#edit_pass").val('1');
	                    show_new_pass();
	                    break;
	                }
                /*
        	
            	HERE IS THE END OF THE LOGIC FOR users PAGE!!!
            	
            	HERE IS THE START OF THE LOGIC FOR vendors PAGE!!!
            		
            	*/
            		case "delete_vendor":
                    {
                        var msg = "Delete " + $(el).find("#name").text() + " ?";
						var x=window.confirm(msg)
						if (x){
							do_del($(el).find("#vid").text(), "vendor");
						}
						break;
                    }
                case "insert_vendor":
                    {
                    	$("#add_new_title").html('Add New Vendor');
                    	$("#edit_id").val('0');
                       	show_add_new();
                        break;
                    }

                case "edit_vendor":
                    {
                    	var msg = "Edit " + $(el).find("#name").text() + " ?";
                    	$("#add_new_title").html(msg);
                        $("#vendor").val($(el).find("#name").text());
                        $("#first_contact").val($(el).find("#contact_first").text());
                        $("#last_contact").val($(el).find("#contact_last").text());
                        $("#address").val($(el).find("#addr").text());
                        $("#city_sz").val($(el).find("#city").text());
                        $("#state option[value="+$(el).find("#s_state").text()+"]").attr('selected', 'selected');
                        $("#post").val($(el).find("#zip").text());
                        $("#edit_id").val($(el).find("#vid").text());
                        show_add_new();
                        break;
                    }
                /*
        	
            	HERE IS THE END OF THE LOGIC FOR vendors PAGE!!!
                       
            	HERE IS THE START OF THE LOGIC FOR producttypes PAGE!!!
            	
            	*/
	                
                case "delete_option":
                {
                    var msg = "Delete " + $(el).find("#code_p").text() + " = " + $(el).find("#desc_p").text() + " option?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#id_p").text(), "pt_option");
					}
					break;
                }
                case "edit_option":
                {
                	$("#ptype0").val($(el).find("#p_type").text());
                	$("#ptype0").attr('disabled', 'disabled');
                	$.getJSON("http://brumbo.net/new/admin/get_pt/"+$(el).find("#id").text(),{ajax: 'true'}, function(l){
                		for (var j = 0; j < parseInt($('#fc0').val()); j++){
                			$('#minus5').trigger('click');
                		}
				      	for (var i = 0; i < l.length; i++) {
				      		$('#plus5').trigger('click');
				      		$('#code0'+i).val(l[i].optionValue);
				      		$('#desc0'+i).val(l[i].optionDisplay);
				      		$('#fc0').val(i+1);
				      	}
			        })
			        $('#pt_id0').val($(el).find("#id").text());
                	show_add_new();
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR producttypes PAGE!!!
            	
            	HERE IS THE START OF THE LOGIC FOR posts PAGE!!!
            	
            	*/
	                    
                case "new_post":
                {
                	//$("#ptype").val($(el).find("#p_type").text());
                	show_add_new();
					break;
                }
                case "edit_post":
                {
                	$("#postname").val($(el).find("#s_name").text());
                	$("#address").val($(el).find("#s_addr").text());
                	$("#city_sz").val($(el).find("#s_city").text());
                	$("#state option[value="+$(el).find("#s_state").text()+"]").attr('selected', 'selected');
                	$("#post").val($(el).find("#s_zip").text());
                	$("#edit_id").val($(el).find("#id_s").text());
                	show_add_new();
					break;
                }
                case "delete_post":
                {
                    var msg = "Delete " + $(el).find("#s_name").text() + " ?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#id_s").text(), "post");
					}
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR posts PAGE!!!
                
                HERE IS THE START OF THE LOGIC FOR product PAGE!!!
            	
            	*/
	                    
                case "new_product":
                {
                	$('#post_aid').val($('#posts_all').val());
                	show_add_new();
					break;
                }
                case "edit_product":
                {
                	$('#post_aid').val($('#posts_all').val());
                	$('#p_id').val($(el).find("#id").text());
					$.getJSON("http://brumbo.net/new/admin/get_pr_dets/"+$(el).find("#id").text(),{ajax: 'true'}, function(j){				        
						$('#pcode').val(j[0].pcode);
						$("#ptype option[value="+j[3].ptid+"]").attr('selected', 'selected');
						$("#vend option[value="+j[2].vendor+"]").attr('selected', 'selected');
						$('#lname').val(j[4].ln);
						$('#descr').val(j[5].pd);
						$('#costd').val(j[6].cost);
				        show_add_new();
				    })
					break;
                }
                case "delete_product":
                {
                    var msg = "Delete product?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#id").text(), "product");
					}
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR product PAGE!!!
                
            	HERE IS THE START OF THE LOGIC FOR ordersearch PAGE!!!
            	
            	*/
	                    
                case "new_order":
                {
                	window.location.href = "http://brumbo.net/new/orderentry"
					break;
                }
                case "edit_order":
                {
                	$('#alink').trigger('click');                       	
                	get_list($(el).find("#id").text());
					break;
                }
                case "delete_order":
                {
                    var msg = "Delete order?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#id").text(), "order");
					}
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR ordersearch PAGE!!!
            	
            	HERE IS THE START OF THE LOGIC FOR art PAGE!!!
            	
            	*/
	                    
                case "upload_file":
                {	
                	$('#image_field').hide();
                	$('#new_pic').show();
                	$('#cpath').val($(el).find("#path").val());
					break;
                }
                case "comment_file":
                {
//                	$("#sellername").val($(el).find("#s_name").text());
//                	$("#edit_id").val($(el).find("#id_s").text());
//                	show_add_new();
alert('comment');
					break;
                }
                case "download_files":
                {
                   	window.location.href = 'http://brumbo.net/new/art/download/'+$(el).find("#path").val();
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR art PAGE!!!
            	
            	HERE IS THE START OF THE LOGIC FOR campaigns PAGE!!!
            	
            	*/
	                    
                case "insert_comp":
                {	
					add_new_company();
					break;
                }
                case "edit_comp":
                {
                	console.log(parseInt($(el).find("#co_pid").val()));
                	$("#companyn").val($(el).find("#coname").text());
                	$("#companyc").val($(el).find("#coc").val());
                	$("#post option[value="+parseInt($(el).find("#co_pid").val())+"]").attr('selected', 'selected');
                	$("#edit_coid").val($(el).find("#coid").val());
					add_new_company();
					break;
                }
                case "delete_comp":
                {
       				break;
                }         
                case "edit_camp":
                {
                	$('#edit_caid').val($(el).find("#caid").val());
					$.getJSON("http://brumbo.net/new/admin/get_campaign_dets/"+$(el).find("#caid").val(),{ajax: 'true'}, function(j){
				        $('#cac').val(j[0].campaign_code);
				        $('#postca').val(j[1].post_id);
				        $.getJSON("http://brumbo.net/new/admin/get_companies/"+j[1].post_id,{ajax: 'true'}, function(l){
					      	var options = '';
					      	for (var i = 0; i < l.length; i++) {
					      		var sel="";
					      		if(l[i].optionValue == j[2].company){
					      			sel = " selected=selected"
					      		}
					        	options += '<option value="' + l[i].optionValue + '"'+sel+'>' + l[i].optionDisplay + '</option>';
					      	}
				        	$("#comca").html(options);
				        })
				        $('#datepicker').val(j[3].tdate);
				        $('#datepicker').attr('readonly', 'readonly');
				        $('#datepicker2').val(j[4].submit_date);
				        $('#datepicker2').attr('readonly', 'readonly');
				        $('#poc').val(j[5].poc);
				        $('#datepicker3').val(j[6].pdate);
				        $('#datepicke3').attr('readonly', 'readonly');
				        $("#vendor option[value="+j[7].vendor+"]").attr('selected', 'selected');
				        add_new_campaign();
				    })
					break;
                }
                case "delete_camp":
                {
                	var msg = "Delete Campaign "+$(el).find("#caname").text()+"?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#caid").val(), "camp");
					}
       				break;
                }
                case "insert_cplat":
                {	
                	$('#pname').val('');
                	$('#cid').val($(el).find("#coid").val());
					add_new_pt();
					break;
                }
                case "edit_cplat":
                {	
                	$('#pname').val($(el).find("#ptname").text());
                	$('#edit_ptid').val($(el).find("#ptid").val());
                	$('#cid').val($(el).find("#comid").val());
					add_new_pt();
					break;
                }
                case "delete_cplat":
                {	
                	var msg = "Delete Platoon "+$(el).find("#ptname").text()+"?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#ptid").val(), "plat");
					}
					break;
                }
                case "insert_sol":
                {	
                	$('#pid').val($(el).find("#ptid").val());
					add_new_sol();
					break;
                }
                case "edit_sol":
                {	
                	$('#fname').val($(el).find("#frst_name").text());
                	$('#lname').val($(el).find("#lst_name").text());
                	$.getJSON("http://brumbo.net/new/admin/get_sol_dets/"+$(el).find("#sid").val(),{ajax: 'true'}, function(j){
                		$('#address').val(j[0].address);
                		$('#city_sz').val(j[1].city);
                		$("#state option[value="+j[2].state+"]").attr('selected', 'selected');
                		$('#postc').val(j[3].zip);
                	})
                	$('#edit_sol').val($(el).find("#sid").val());
                	$('#pid').val($(el).find("#ptid2").val());
					add_new_sol();
					break;
                }
                case "delete_sol":
                {	
                	var msg = "Delete Soldier "+$(el).find("#sname").text()+"?";
					var x=window.confirm(msg)
					if (x){
						do_del($(el).find("#sid").val(), "sol");
					}
					break;
                }
                /*
                
                HERE IS THE END OF THE LOGIC FOR campaigns PAGE!!!
            	
            	*/
            }
        }
        $(function() {
            $("table.product_types").bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });    
        
             
        function edit_option(el){
        	$("#ptype0").val($(el).find("#p_type").text());
        	$("#ptype0").attr('disabled', 'disabled');
        	$.getJSON("http://brumbo.net/new/admin/get_pt/"+$(el).find("#id").text(),{ajax: 'true'}, function(l){
        		for (var j = 0; j < parseInt($('#fc0').val()); j++){
        			$('#minus5').trigger('click');
        		}
		      	for (var i = 0; i < l.length; i++) {
		      		$('#plus5').trigger('click');
		      		$('#code0'+i).val(l[i].optionValue);
		      		$('#desc0'+i).val(l[i].optionDisplay);
		      		$('#fc0').val(i+1);
		      	}
	        })
	        $('#pt_id0').val($(el).find("#id").text());
        	show_add_new();
        }