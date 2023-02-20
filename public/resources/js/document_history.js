var DOCUMENT_HISTORY='DocumentHistoryGrid';
var GridLoaded=false;
$(document).ready(function() {
	DocumentHistoryGridPopulate();
    $(window).bind('resize', function() {
        $("#"+DOCUMENT_HISTORY).setGridWidth($('body').width()-($('ul.nav').width()+85), true);
    }).trigger('resize');
});

function DoGridDelete() {
	$('#del_' + DOCUMENT_HISTORY).click();
}

function DocumentHistoryGridPopulate() {
	var GridURL=URLPath+'data/documenthistory';
    var GridID=DOCUMENT_HISTORY;
	if (GridLoaded) {
		$("#"+DOCUMENT_HISTORY).jqGrid().setGridParam({url : GridURL}).trigger("reloadGrid");
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
            $("#"+DOCUMENT_HISTORY).trigger( 'reloadGrid' );
        }
    };

	GridLoaded=true;
    $("#"+DOCUMENT_HISTORY).jqGrid({
        url: URLPath+'data/documenthistory',
        datatype: "json",
        colNames: [
           'Created On',
           'Imported On',
           'Image Src',
           'Post',
           'Confidence',
           'By',
           'OCR Payload'
        ],
        colModel: [
           { name: 'created_at', index: 'created_at', width: 15 },
           { name: 'imported_on', index: 'imported_on', width: 15 },
           { name: 'image_resource_name', index: 'image_resource_name', width: 15 },
           { name: 'post', index: 'post', width: 15 },
           { name: 'summary_confidence_score', index: 'summary_confidence_score', width: 15 },
           { name: 'created_by', index: 'created_by', width: 8 },
           { name: 'ocr_payload', index: 'ocr_payload', width: 8 }
        ],
        pager: '#'+DOCUMENT_HISTORY+'Pager',
        toppager : true,
        editurl: GridURL,
        caption: "DOCUMENT HISTORY GRID",
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
        	var rowData = jQuery('#'+DOCUMENT_HISTORY).getRowData(id);
        	CycleOrderId = rowData['id'];
        	$('#order-details-dialog').dialog("open");
        }
    });
    fEditGridOptions = EditGridOptions(fAfterComplete, null, fAfterSubmit);
    fAddGridOptions=AddGridOptions(fAfterComplete, null, fAfterSubmit);
    fDelGridOptions=DelGridOptions(fAfterComplete, null, fAfterSubmit);
    jQuery('#'+DOCUMENT_HISTORY).jqGrid('navGrid','#'+DOCUMENT_HISTORY+'Pager',
    		{ add: false, del : true, edit: false },
    		{}, {}, {},
    		fDelGridOptions, JQGridSearchOptions, JQGridViewOptions
    );
    GenTopPager(DOCUMENT_HISTORY);
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