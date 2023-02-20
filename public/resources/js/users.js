var USERS_GRID='UsersGrid';
var GridLoaded=false;
var UserTypesSelect=null;
var RolesSelect=null;
var PostsDataSelect=null;
$(document).ready(function() {
	UserTypesSelect=LookupQueryCached('user_types_all', false);
    RolesSelect=LookupQueryCached('roles_all', false);
	PostsDataSelect=LookupQueryCached('posts_all', true);
	UserGridPopulate();
    $(window).bind('resize', function() {
        $("#"+USERS_GRID).setGridWidth($('body').width()-($('ul.nav').width()+85), true);
    }).trigger('resize');

});
function UserGridPopulate() {
	var GridURL=URLPath+'data/users';
	if (GridLoaded) {
		$("#"+USERS_GRID).jqGrid().setGridParam({url : GridURL}).trigger("reloadGrid");
		return true;
	}
	
	ShowMessage("<font color='gold'><strong>Loading data.... thanks for your patience<strong></font>", true);
	var GridID=USERS_GRID;
	var fAfterComplete=function(response, postdata, formid) {
    	console.log('grid.fAfterComplete');
    	//UpdatePlatoonList();
	    var ret=parseResponse(response);//ret=({message:??,code:#,new_id: #});
	    ShowMessage(ret.message, (ret.code != 0));
		return true;
	};
	GridLoaded=true;
    $("#"+USERS_GRID).jqGrid({
        url: URLPath+'data/users',
        datatype: "json",
        colNames: [
            'Id',
            'User Email',
            'User Type',
            'Post Name',
            'Role',
            'Password',
            'Post Id'
        ],
        /*

         */
        colModel: [
            { name: 'id', index: 'id', width: 15, hidden: true, editable: false, editrules:{edithidden:true }  },
            { name: 'user_email', index: 'user_email', width: 15, hidden: false, editable: true, editrules:{edithidden:true }  },
            { name: 'usertype', index: 'usertype', width: 15, hidden: false, editable: false, editrules:{edithidden:true }  },
            { name: 'post_name', index: 'post_name', width: 15, hidden: false, editable: false, editrules:{edithidden:true }  },
            { name: 'role', index: 'role', width: 15, hidden: true, editable: true, edittype: 'select', editoptions: { value: RolesSelect }, editrules:{edithidden:true } },
            { name: 'user_password', index: 'user_password', width: 15, hidden: true, editable: true, editrules:{edithidden:true }  },
            { name: 'post_id', index: 'post_id', width: 15, hidden: true, editable: false, editrules:{edithidden:true }  },
        ],
        pager: '#'+USERS_GRID+'Pager',
        toppager : true,
        editurl: GridURL,
        caption:null,
        sortname: 'user_email',
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
        }
    });
    fEditGridOptions = EditGridOptions(fAfterComplete);
    fAddGridOptions=AddGridOptions(fAfterComplete);        
    fDelGridOptions=DelGridOptions(fAfterComplete);        
    jQuery('#'+USERS_GRID).jqGrid('navGrid','#'+USERS_GRID+'Pager',
    		{ add: true, del : true, edit: true },
    		{}, fEditGridOptions, fAddGridOptions,
    		fDelGridOptions, JQGridSearchOptions, JQGridViewOptions
    );
    jQuery('#'+USERS_GRID).setGridWidth(800);
    jQuery('#'+USERS_GRID+'Pager').setGridWidth(800).width(800);
    GenTopPager(USERS_GRID);
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