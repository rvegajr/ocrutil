var EXCEPTION_QUEUE='ExceptionQueueGrid';
var GridLoaded=false;
$(document).ready(function() {
	ExceptionQueueGridPopulate();
    $(window).bind('resize', function() {
        $("#"+EXCEPTION_QUEUE).setGridWidth($('body').width()-($('ul.nav').width()+85), true);
    }).trigger('resize');
});

function DoGridDelete() {
	$('#del_' + EXCEPTION_QUEUE).click();
}

function ExceptionQueueGridPopulate() {
	var GridURL=URLPath+'data/exceptionqueue';
    var GridID=EXCEPTION_QUEUE;
	if (GridLoaded) {
		$("#"+EXCEPTION_QUEUE).jqGrid().setGridParam({url : GridURL}).trigger("reloadGrid");
		return true;
	}
	
	ShowMessage("<font color='gold'><strong>Loading data.... thanks for your patience<strong></font>", true);
	var fAfterComplete=function(response, postdata, formid) {
        console.log('grid.fAfterComplete');
    	//UpdatePlatoonList();
	    var ret=parseResponse(response);//ret=({message:??,code:#,new_id: #});
	    ShowMessage(ret.message, (ret.code != 0));
		return true;
	};
    var fAfterSubmit=function(response) {
        if (response.responseText.indexOf("success")>-1) {
            $("#"+CYCLES_GRID).trigger( 'reloadGrid' );
        }
    };
	GridLoaded=true;
    $("#"+EXCEPTION_QUEUE).jqGrid({
        url: URLPath+'data/exceptionqueue',
        datatype: "json",
        colNames: [
            'Created On',
            'Processed On',
            'Image Src',
            'Confidence',
            'Post',
            'Created By',
        ],
        colModel: [
           { name: 'created_at', index: 'created_at', width: 15 },
           { name: 'processed_on', index: 'processed_on', width: 15 },
           { name: 'image_resource_name', index: 'image_resource_name', width: 15 },
           { name: 'summary_confidence_score', index: 'summary_confidence_score', width: 15 },
           { name: 'post', index: 'post', width: 15 },
           { name: 'created_by', index: 'created_by', width: 8 }
        ],
        pager: '#'+EXCEPTION_QUEUE+'Pager',
        toppager : true,
        editurl: GridURL,
        caption: "EXCEPTION QUEUE GRID",
        sortname: 'created_at',
        sortorder: 'desc',
        height : 'auto',
        afterShowForm : function() {
        	console.log('grid.afterShowForm');
        },
        beforeRequest : function() {
        },
        gridComplete : function() { 
        },
        loadComplete : function(data) { 
        	console.log('grid.loadComplete');
        },
        onSelectRow: function(id){
        	var rowData = jQuery('#'+EXCEPTION_QUEUE).getRowData(id);
        	CycleOrderId = rowData['id'];
        	$('#order-details-dialog').dialog("open");
        }
    });
    fEditGridOptions = EditGridOptions(fAfterComplete, null, fAfterSubmit);
    fAddGridOptions=AddGridOptions(fAfterComplete, null, fAfterSubmit);
    fDelGridOptions=DelGridOptions(fAfterComplete, null, fAfterSubmit);
    jQuery('#'+EXCEPTION_QUEUE).jqGrid('navGrid','#'+EXCEPTION_QUEUE+'Pager',
    		{ add: false, del : true, edit: false },
    		{}, {}, {},
    		fDelGridOptions, JQGridSearchOptions, JQGridViewOptions
    );
    GenTopPager(EXCEPTION_QUEUE);
}

function ShowMessage(html, showAjaxLoader) {
    //$('#msg').html(html);
    //$('#msg').fadeTo("slow", 1).animate({ opacity: 1.0 }, 3000).fadeTo("slow", 0);
	showAjaxLoader=(showAjaxLoader==true);
	if (showAjaxLoader) {
		$('.ajax_loader_image').show();
	} else {
		$('.ajax_loader_image').hide();
	}
    $('#status_message').html(html);
    $('#status_message').animate({ opacity: 1.0 }, 3000).fadeTo("slow", 0);
    //$('#status_message').fadeTo("slow", 1).animate({ opacity: 1.0 }, 3000).fadeTo("slow", 0);
} 