var ARCHIVE_HISTORY='ArchiveHistoryGrid';
var GridLoaded=false;
$(document).ready(function() {
	ArchiveHistoryGridPopulate();
    $(window).bind('resize', function() {
        $("#"+ARCHIVE_HISTORY).setGridWidth($('body').width()-($('ul.nav').width()+85), true);
    }).trigger('resize');
});

function DoGridDelete() {
	$('#del_' + ARCHIVE_HISTORY).click();
}

function ArchiveHistoryGridPopulate() {
	var GridURL=URLPath+'data/archivehistory';
    var GridID=ARCHIVE_HISTORY;
	if (GridLoaded) {
		$("#"+ARCHIVE_HISTORY).jqGrid().setGridParam({url : GridURL}).trigger("reloadGrid");
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
    $("#"+ARCHIVE_HISTORY).jqGrid({
        url: URLPath+'data/archivehistory',
        datatype: "json",
        colNames: [
            'Archived On',
            'Processed On',
            'Imported On',
            'Image Src',
            'Post',
            'Confidence',
            'Created By',
            'Archived To',
        ],
        colModel: [
            { name: 'archived_on', index: 'archived_on', width: 15 },
            { name: 'processed_on', index: 'processed_on', width: 15 },
            { name: 'imported_on', index: 'imported_on', width: 15 },
            { name: 'image_resource_name', index: 'image_resource_name', width: 15 },
            { name: 'post', index: 'post', width: 15 },
            { name: 'summary_confidence_score', index: 'summary_confidence_score', width: 15 },
            { name: 'created_by', index: 'created_by', width: 8 },
            { name: 'archived_to', index: 'archived_to', width: 8 }
        ],
        pager: '#'+ARCHIVE_HISTORY+'Pager',
        toppager : true,
        editurl: GridURL,
        caption: "ARCHIVED HISTORY GRID",
        sortname: 'archived_on',
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
        	var rowData = jQuery('#'+ARCHIVE_HISTORY).getRowData(id);
        	CycleOrderId = rowData['id'];
        	$('#order-details-dialog').dialog("open");
        }
    });
    fEditGridOptions = EditGridOptions(fAfterComplete, null, fAfterSubmit);
    fAddGridOptions=AddGridOptions(fAfterComplete, null, fAfterSubmit);
    fDelGridOptions=DelGridOptions(fAfterComplete, null, fAfterSubmit);
    jQuery('#'+ARCHIVE_HISTORY).jqGrid('navGrid','#'+ARCHIVE_HISTORY+'Pager',
    		{ add: false, del : true, edit: false },
    		{}, {}, {},
    		fDelGridOptions, JQGridSearchOptions, JQGridViewOptions
    );
    GenTopPager(ARCHIVE_HISTORY);
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