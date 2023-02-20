var debugging = false; // or true
if (typeof console == "undefined") var console = { log: function() {} }; 
else if (!debugging || typeof console.log == "undefined") console.log = function() {};
var TRUE=1;
var FALSE=0;

var displaySize=1.0;
$(document).ready(function() {
	$(window).bind('resize', function() {
		var navWidth=$('ul.nav').width()+85;
		var bodyWidth=$('body').width();
		if (bodyWidth>1980) {
			$("body").css("font-size", "1.0em")
			displaySize=1.0;
		} else if (bodyWidth<=1980) {
			$("body").css("font-size", "0.9em");
			displaySize=0.9;
		} else if (bodyWidth<=1240) {
			$("body").css("font-size", "0.8em");
			displaySize=0.8;
		} else if (bodyWidth<=980) {
			$("body").css("font-size", "0.7em");
			displaySize=0.7;
		} else if (bodyWidth<=780) {
			$("body").css("font-size", "0.6em");
			displaySize=0.6;
		}
		$('input.qtyele').css('width', (displaySize*150)+'px');
		$('input.qtycount').css('width', (displaySize*150)+'px');
	}).trigger('resize');
});

function redirect(newurl, addhttp) {
	if ( addhttp ) {
		window.location.href='http://'+newurl;
	} else {
		window.location.href=newurl;
	}
}
var URLPath=location.href.substring(0,location.href.lastIndexOf("index.php"));

//** Hashtable Implementation -  http://weblogs.asp.net/ssadasivuni/archive/2003/09/17/27902.aspx
function Hashtable(){
this.clear = hashtable_clear;
this.containsKey = hashtable_containsKey;
this.containsValue = hashtable_containsValue;
this.get = hashtable_get;
this.isEmpty = hashtable_isEmpty;
this.keys = hashtable_keys;
this.put = hashtable_put;
this.remove = hashtable_remove;
this.size = hashtable_size;
this.toString = hashtable_toString;
this.fromString = hashtable_fromString;
this.toString2 = hashtable_toString2;
this.fromString2 = hashtable_fromString2;
this.values = hashtable_values;
this.nonZeroCount = hashtable_nonZeroCount;
this.zeroValues =  hashtable_zeroValues;
this.zeroKeys = hashtable_zeroKeys;
this.nonZeroKeys = hashtable_nonZeroKeys;
this.hashtable = new Array();
}

/*=======Private methods for internal use only========*/

function hashtable_clear(){
this.hashtable = new Array();
}

function hashtable_containsKey(key){
var exists = false;
for (var i in this.hashtable) {
  if (i == key && this.hashtable[i] != null) {
      exists = true;
      break;
  }
}
return exists;
}

function hashtable_containsValue(value){
var contains = false;
if (value != null) {
  for (var i in this.hashtable) {
      if (this.hashtable[i] == value) {
          contains = true;
          break;
      }
  }
}
return contains;
}

function hashtable_get(key){
return this.hashtable[key];
}

function hashtable_isEmpty(){
return (parseInt(this.size()) == 0) ? true : false;
}

function hashtable_keys(){
var keys = new Array();
for (var i in this.hashtable) {
  if (this.hashtable[i] != null) 
      keys.push(i);
}
return keys;
}

function hashtable_put(key, value){
if (key == null || value == null) {
  throw "NullPointerException {" + key + "},{" + value + "}";
}else{
  this.hashtable[key] = value;
}
}

function hashtable_remove(key){
var rtn = this.hashtable[key];
this.hashtable[key] = null;
return rtn;
}

function hashtable_size(){
var size = 0;
for (var i in this.hashtable) {
  if (this.hashtable[i] != null) 
      size ++;
}
return size;
}

function hashtable_toString(keyValueFormatting){
var result = "";
var cnt = 0;
for (var i in this.hashtable)
{      
  if (this.hashtable[i] != null) {
      if ( keyValueFormatting==true ) { 
          result += (cnt==0 ? "" : ",") + i + "=" + this.hashtable[i];   
      } else {
          result += "{" + i + "},{" + this.hashtable[i] + "}\n";   
      }
  }
  cnt++;
}
return result;
}

function hashtable_fromString(htString){
	try {
	    if (( htString == null ) || (htString.length == 0)) {
	        return false;
	    } else {
      var arr = htString.split("\n");
      for(var i = 0; i < arr.length; i++){
          var kv = arr[i].split("},{");
          //var kv = htString.split("},{");
          this.put(kv[0].substring(1), kv[1].substring(0, kv[1].length - 2));
      }
      return true;
  }
	} catch ( e ) {
		window.alert("MiscUtilities.js->hashtable_fromString(htString=" + htString + ") Error! " + e.name + "-" + e.message ); 
		return false;
	}
}


function hashtable_toString2(keyValueFormatting){
var result = "";
var cnt = 0;
for (var i in this.hashtable)
{      
  if (this.hashtable[i] != null) {
  	result += (cnt==0 ? "" : "$") + i + "#" + this.hashtable[i]; 
  }
  cnt++;
}
return result;
}

function hashtable_fromString2(htString){
	try {
	    if (( htString == null ) || (htString.length == 0)) {
	        return false;
	    } else {
      var arr = htString.split("$");
      for(var i = 0; i < arr.length; i++){
      	if ( arr[i].length>0 ) { 
          var kv = arr[i].split("#");
          this.put(kv[0], kv[1]);
        }
      }
      return true;
  }
	} catch ( e ) {
		window.alert("MiscUtilities.js->hashtable_fromString2(htString=" + htString + ") Error! " + e.name + "-" + e.message ); 
		return false;
	}
}

function hashtable_nonZeroCount(){
var cnt = 0;
for (var i in this.hashtable)
{      
  if (( this.hashtable[i] == null) || ( this.hashtable[i] <= 0 )) {
  } else {
      cnt++;
  }
}
return cnt;
}

function hashtable_zeroValues(){
var values = new Array();

for (var i in this.hashtable) {
  if ( (this.hashtable[i] != null ) && ( this.hashtable[i] <= 0 ) ) {
			values.push(this.hashtable[i]);
  }
}
return values;
}

function hashtable_zeroKeys() {
var values = new Array();

for (var i in this.hashtable) {
  if ((this.hashtable[i] != null) && (this.hashtable[i] <= 0)) {
      values.push(i);
  }
}
return values;
}

function hashtable_nonZeroKeys() {
	  var values = new Array();

	  for (var i in this.hashtable) {
	      if ((this.hashtable[i] != null) && (this.hashtable[i] > 0)) {
	          values.push(i);
	      }
	  }
	  return values;
}

function hashtable_values() {
var values = new Array();
for (var i in this.hashtable) {
  if (this.hashtable[i] != null) 
      values.push(this.hashtable[i]);
}
return values;
}

//** End Hashtable


function pad(n, totalDigits) 
{ 
	n = n.toString(); 
	var pd = ''; 
	if (totalDigits > n.length) { 
	    for (i=0; i < (totalDigits-n.length); i++) { 
	        pd += '0'; 
	    } 
	} 
	return pd + n.toString(); 
} 


function nowAsStr() {
	var date = new Date();	
	var day = date.getDate();	
	var month = date.getMonth() + 1;	
	var yy = date.getYear(); 	
	var year = (yy < 1000) ? yy + 1900 : yy; 	
	var hr = date.getHours(); 	
	var hours = (hr < 10) ? ('0' + hr) : hr; 	
	var _min =  date.getMinutes(); 	
	var minutes = ((_min < 10) ? ('0' + _min) : _min);
	var second =  date.getSeconds(); 	
	var millisec =  date.getMilliseconds(); 	
	return month + '/' + day + '/' + year + ' ' + hours + ':' + minutes +  ':' + second +'.' + millisec;
}               


var DA_ALPHANUMERIC = '[A-Za-z0-9 ]+';
var DA_ALPHANUMERIC_NAME = '[A-Za-z0-9\' ]+';
var DA_NUMERIC = '[0-9]+';
var DA_ALPHANUMERIC_STRICT = '[A-Za-z0-9]+';
var DA_TEXT = '[A-Za-z0-9 \!\@\#\$\%\^\&\*\(\)\\\<\>\?\/\:\;\"\'\+\=\-\_\.\,\t\n\r]+';
var DA_PHONE = '[0-9()\\\-EeXxTt ]+';
var DA_URL = '[A-Za-z0-9\:\. ]+';
var DA_EMAIL = '[A-Za-z0-9\@\.]+';
var DA_DATETIME = '[0-9aApPmM\/\: ]+';

function fBeforeShowFormGlobal(frmgr) {
	//This will go through each element of the grid,  look through each of the fields and 
	// searches for a field called 'dataallowed',  if it finds this,  it will add
	// an event handler (or add invoke a jquery plugin)
	// This also will add jquery.bt.js code that give a popup of the allowed date format in the field
	FormDataAllowed.clear();
	var colModel=$('#'+frmgr.selector.split('_')[1]).jqGrid('getGridParam','colModel');
	for ( i=0; i<colModel.length; i++ ) {
		var col=colModel[i];
		var dataAllowed=col.dataallowed;
		if ( dataAllowed != null ) {
			FormDataAllowed.put(col.name, dataAllowed);
			var title='';
    		if ( dataAllowed != null ) {
    			if (dataAllowed==DA_ALPHANUMERIC) {
					title='Numbers and letters with no secial characters';
				} else if (dataAllowed==DA_ALPHANUMERIC_NAME) {
					title='Numbers and letters with no secial characters (apostrophie allowed)';
				} else if (dataAllowed==DA_NUMERIC) {
					title='Numbers only';
				} else if (dataAllowed==DA_ALPHANUMERIC_STRICT) {
					title='Numbers and letters with no spaces or special characters';
				} else if (dataAllowed==DA_TEXT) {
				} else if (dataAllowed==DA_PHONE) {
					title='###-###-####';
				} else if (dataAllowed==DA_URL) {
					title='http://www.domain.com';
				} else if (dataAllowed==DA_EMAIL) {
					title='name@domain.com';
				} else if (dataAllowed==DA_DATETIME) {
					title='mm/dd/yyyy [hh:mm:ss] - [] is optional';
					//$('#'+col.name).jdPicker();
				}
    			if ( title.length > 0 ) {
    				$('#'+col.name).attr('title', title);
    				$('#'+col.name).tooltip({ position: "center right", offset: [-2, 10], effect: "fade", opacity: 0.7 });    				
    			}
    		}
		}
	}
};

var ERROR_CODE_GENERIC=99;
var ERROR_CODE_SQL=100;
var ERROR_CODE_INVALID_USER=101;
var ERROR_CODE_USER_ASSESSMENT=102;
var FormDataAllowed = new Hashtable();
FormDataAllowed.clear;

var lastsel;
//JQuery Validate Rule Constants
var RuleDate = { date: true };

var BooleanTypes = {
    'N': 'No',
    'Y': 'Yes'
};

var AssessmentStatusTypes = {
    'N': 'No',
    'Y': 'Yes',
    'S': 'Submitted'
};

var GroupTypes = {
    '2': 'User',
    '3': 'Coach',
    '4': 'Administrator',
    '0': 'Disable'
};

function EmailValidation(dataToTest)
{
	var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/gi;
	var txt=dataToTest;
	return (txt.match(re)!=null); 
}
function DateTimeValidationOLD(dateToTest)
{
	var re = /(?=\d)^(?:(?!(?:10\D(?:0?[5-9]|1[0-4])\D(?:1582))|(?:0?9\D(?:0?[3-9]|1[0-3])\D(?:1752)))((?:0?[13578]|1[02])|(?:0?[469]|11)(?!\/31)(?!-31)(?!\.31)|(?:0?2(?=.?(?:(?:29.(?!000[04]|(?:(?:1[^0-6]|[2468][^048]|[3579][^26])00))(?:(?:(?:\d\d)(?:[02468][048]|[13579][26])(?!\x20BC))|(?:00(?:42|3[0369]|2[147]|1[258]|09)\x20BC))))))|(?:0?2(?=.(?:(?:\d\D)|(?:[01]\d)|(?:2[0-8])))))([-.\/])(0?[1-9]|[12]\d|3[01])\2(?!0000)((?=(?:00(?:4[0-5]|[0-3]?\d)\x20BC)|(?:\d{4}(?!\x20BC)))\d{4}(?:\x20BC)?)(?:$|(?=\x20\d)\x20))?((?:(?:0?[1-9]|1[012])(?::[0-5]\d){0,2}(?:\x20[aApP][mM]))|(?:[01]\d|2[0-3])(?::[0-5]\d){1,2})?$/gi;
	var txt=dateToTest;
	return (txt.match(re)!=null); 
}
function DateTimeValidation(dateToTest)
{
	var isValid=true;
	try {
		var date = new Date(dateToTest.replace(/-/g,"/"));
	} catch (error) {
		isValid=false;
	}
	return isValid;
}

function PhoneValidation(dataToTest)
{
	var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/gi;
	var txt=dataToTest;
	return (txt.match(re)!=null); 
}
function UrlValidation(dataToTest)
{
	var re = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)$/gi;
	var txt=dataToTest;
	return (txt.match(re)!=null); 
}

function ValidationTest(dataToTest, re)
{
	var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/gi;
	var txt=dataToTest;
	return (txt.match(re)!=null); 
}
function dateTimeVerify(value, colname) {

	if ( value.length > 0 ) {
		if ( !DateTimeValidation( value ) ) {
			return [false,colname+" must be a valid date/time"];
		}
	}
	return [true,""];
}

function phoneVerify(value, colname) {

	if ( value.length > 0 ) {
		if ( !PhoneValidation( value ) ) {
			return [false,colname+" must be a valid phone number 999-999-9999"];
		}
	}
	return [true,""];
}

function LookupQuery(LookUpKey, args) {
	if ((args===true) || (args==null)) args="";
	var LookupURL=URLPath+'data/lookups?'+args+'&lk='+LookUpKey.replace(/\&/g,"___");
	var returnData = $.ajax({url: LookupURL, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve lookup '+LookUpKey);}}).responseText;
	return eval('['+returnData+']')[0];
	//return returnData;
}

function LookupQueryCached(LookUpKey, forceRefresh, args) {
	if (args==null) args="";
	forceRefresh=(forceRefresh==true);
	if ((!forceRefresh) && ($.cookie(LookUpKey))) {
		var returnData=$.cookie(LookUpKey);
		return eval('['+returnData+']')[0]; 
	} else {
		var LookupURL=URLPath+'data/lookups?'+args+'lk='+LookUpKey.replace(/\&/g,"___");
		var returnData = $.ajax({url: LookupURL, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve lookup '+LookUpKey);}}).responseText;
		$.cookie(LookUpKey, returnData, {expires: 14, path: '/'});
		return eval('['+returnData+']')[0];
	}
	//return returnData;
}

function thisWidth() {
    var myWidth = 0, myHeight = 0;
    if (typeof (window.innerWidth) == 'number') {
        //Non-IE
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode'
        myWidth = document.documentElement.clientWidth;
        myHeight = document.documentElement.clientHeight;
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible
        myWidth = document.body.clientWidth;
        myHeight = document.body.clientHeight;
    }
    return myWidth;
}

function atLeastZero(val) {
    if (val < 0) {
        return 5;
    } else {
        return val;
    }
}

function thisHeight() {
    var myWidth = 0, myHeight = 0;
    if (typeof (window.innerWidth) == 'number') {
        //Non-IE
        myWidth = window.innerWidth;
        myHeight = window.innerHeight;
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode'
        myWidth = document.documentElement.clientWidth;
        myHeight = document.documentElement.clientHeight;
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible
        myWidth = document.body.clientWidth;
        myHeight = document.body.clientHeight;
    }
    return myHeight;
}

var JQGridEditOptions = {
	jqModal:true,
	modal:true,
	closeAfterAdd: false,
	clearAfterAdd: true,
	closeAfterEdit: true,
	closeOnEscape: true,
	checkOnSubmit : false, 
	//beforeSubmit: fBeforeSubmitDummy,
	afterSubmit: fAfterSubmitGlobal,
	//afterComplete: fAfterCompleteDummy,
	beforeShowForm: fBeforeShowFormGlobal,
	reloadAfterSubmit: true,
	savekey: [true,13], 
	navkeys: [true,38,40], 
	bottominfo:"Fields marked with (*) are required",
	width: '800px'
};	

var JQGridAddOptions = {
	modal:true,
	jqModal:true,
	closeAfterAdd: false,
	closeAfterEdit: true,
	clearAfterAdd: true,
	closeOnEscape: true,
	checkOnSubmit : false, 
	//beforeSubmit: fBeforeSubmitDummy,
	afterSubmit: fAfterSubmitGlobal,
	//afterComplete: fAfterCompleteDummy,
	beforeShowForm: fBeforeShowFormGlobal,
	reloadAfterSubmit: true,
	savekey: [true,13], 
	navkeys: [true,38,40], 
	bottominfo:"Fields marked with (*) are required",
	width: '400px'
};	

var JQGridDelOptions = {
	jqModal:false, 
	reloadAfterSubmit:true,
	closeOnEscape:true,
	afterSubmit: fAfterSubmitGlobal
	//beforeSubmit: fBeforeSubmitDummy,
	//afterComplete: fAfterCompleteDummy
};	

var JQGridViewOptions = {
	jqModal:false,
	navkeys: [true,38,40], 
	height:250,
	closeOnEscape:true
};

var JQGridSearchOptions = {
	closeOnEscape:true
};

function EditGridOptions( afterCompleteFunc, beforeSubmitFunc, afterSubmitFunc ) {
	var NewGridOptions = jQuery.extend(true, {}, JQGridEditOptions);
	if (typeof beforeSubmitFunc == 'function') {NewGridOptions.beforeSubmit=beforeSubmitFunc;}
	if (typeof afterCompleteFunc == 'function') {NewGridOptions.afterComplete=afterCompleteFunc;}
	NewGridOptions.afterSubmit=(typeof afterSubmitFunc == 'function') ? afterSubmitFunc : fAfterSubmitGlobal;
	return NewGridOptions;
}

function AddGridOptions( afterCompleteFunc, beforeSubmitFunc, afterSubmitFunc ) {
	var NewGridOptions = jQuery.extend(true, {}, JQGridAddOptions);
	if (typeof beforeSubmitFunc == 'function') {NewGridOptions.beforeSubmit=beforeSubmitFunc;}
	if (typeof afterCompleteFunc == 'function') {NewGridOptions.afterComplete=afterCompleteFunc;}
	NewGridOptions.afterSubmit=(typeof afterSubmitFunc == 'function') ? afterSubmitFunc : fAfterSubmitGlobal;
	return NewGridOptions;
}

function DelGridOptions( afterCompleteFunc, beforeSubmitFunc, afterSubmitFunc ) {
	var NewGridOptions = jQuery.extend(true, {}, JQGridDelOptions);
	if (typeof beforeSubmitFunc == 'function') {NewGridOptions.beforeSubmit=beforeSubmitFunc;}
	if (typeof afterCompleteFunc == 'function') {NewGridOptions.afterComplete=afterCompleteFunc;}
	NewGridOptions.afterSubmit=(typeof afterSubmitFunc == 'function') ? afterSubmitFunc : fAfterSubmitGlobal;
	return NewGridOptions;
}

function GenTopPager(gridName) {
	$('#'+gridName+'_toppager').find('#pg_' + gridName +'_toppager').hide();
	$('#'+gridName+'_toppager').prepend($('#'+gridName+'Pager').clone(true));
}

function fBeforeSubmitGlobal(postdata, frmgr) { 
    var ret = new Array();
    ret[0] = true;
    ret[1] = ((!ret[0]) ? 'Please correct the fields below' : '');
    return ret;
}

function fAfterSubmitGlobal( data_from_server, array_data) 
{
	var result = parseResponse( data_from_server );
	//var result = data_from_server.responseText.split(';'); 
	if (result.code != 0) { 
		return [false,result.message, ""]; 
	} else { 
		return [true,((result.message=="0"||result.message=="") ? "Success" : result.message), ""]; 
	}
}
function fBeforeSubmitGlobal(postdata, frmgr) { 
    var ret = new Array();
    ret[0] = true;
    ret[1] = ((!ret[0]) ? 'Please correct the fields below' : '');
    return ret;
}

var fStrDateToMMDDYYYY=function(value) {
	var date = new Date(value.replace(/-/g,"/"));
	var dateAsMMDDYYYY = (((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear());
	return dateAsMMDDYYYY;
}


var fDateTimeCustomElement=function(value, options) {
	var el = document.createElement("input");
	el.type="date";
	el.className="form-control FormElement";
	//el.value = fStrDateToMMDDYYYY(value);
	el.valueAsDate = new Date(value.replace(/-/g,"/"));
	return el;
}
var fDateTimeCustomValue=function(elem, operation, value) {
	if(operation === 'get') {
		return fStrDateToMMDDYYYY($(elem).val());
	} else if(operation === 'set') {
		$('input',elem).val(value);
	}
}

var fDateCustomElement=function(value, options) {
	var el = document.createElement("input");
	el.type="date";
	el.className="form-control FormElement";
	//el.value = fStrDateToMMDDYYYY(value);
	el.valueAsDate = new Date(value.replace(/-/g,"/"));
	return el;
}
var fDateCustomValue=function(elem, operation, value) {
	if(operation === 'get') {
		return fStrDateToMMDDYYYY($(elem).val());
	} else if(operation === 'set') {
		$('input',elem).val(value);
	}
}

function parseResponse(response) {
    var retCode = -1;
    var newID = 0;
    var retMessage = "";

    if ( response.responseText.charAt(0) == "{" ) { //isJSON
    	return eval('('+response.responseText+')');
    } else {
        retCode=response.responseText.extract(/\<code\b[^\>]*>(.*?)\<\/code\>/g, 1);
        newID=response.responseText.extract(/\<new_id\b[^\>]*>(.*?)\<\/new_id\>/g, 1);
        retMessage=response.responseText.extract(/\<message\b[^\>]*>(.*?)\<\/message\>/g, 1);
        retCode=((typeof retCode=="object") ? retCode[0] : retCode );
		if (retCode===undefined) {
			//If no retcode is passed, then we figured out the response standard
			return ({message:response.status<=204?"":response.responseText,code:response.status<=204?0:response.status,new_id: newID});
		}
        newID=((typeof newID=="object") ? newID[0] : newID ); 
        retMessage=((typeof retMessage=="object") ? retMessage[0] : retMessage ); 
        
    	return ({message:retMessage,code:retCode,new_id: newID});
	}
}

function fAfterCompleteGlobal(response, postdata, formid) {
    var ret=parseResponse(response);//ret=({message:??,code:#,new_id: #});
	return true;
}


function GetJQGridFirstRowID( GridID ) {
	var topID = $('#' + GridID + ' tbody:first-child tr:first').attr('id');
	if ((!(topID)) || ( topID == "" )) {
		topID = $('#' + GridID + ' tbody:first-child tr:nth-child(2)').attr('id');
	}
	if ((!(topID)) || ( topID == "" )) {
		topID = -1;
	}
	return topID;
}

var gibberish=["This is just some filler text", "Welcome to Dynamic Drive CSS Library", "Demo content nothing to read here"]
function filltext(words){
for (var i=0; i<words; i++)
document.write(gibberish[Math.floor(Math.random()*3)]+" ")
}

String.prototype.extract = function( regex, n ) {
	 
    n = n === undefined ? 0 : n;
 
    if ( !regex.global ) {
        return this.match(regex)[n] || '';
    }
 
    var match,
        extracted = [];
 
    while ( (match = regex.exec(this)) ) {
        extracted[extracted.length] = match[n] || '';
    }
 
    return extracted;
 
};

String.prototype.endsWith = function(str)
{
    var lastIndex = this.lastIndexOf(str);
    return (lastIndex != -1) && (lastIndex + str.length == this.length);
}

function getOffsetX(obj){
	var xPos=obj.offsetLeft;
	var parent=obj.offsetParent;
	while(parent!=null){xPos+=parent.offsetLeft;parent=parent.offsetParent;}
	return xPos;
}
function getOffsetY(obj){
	var yPos=obj.offsetTop;
	var parent=obj.offsetParent;
	while(parent!=null){yPos+=parent.offsetTop;parent=parent.offsetParent;}
	return yPos;
}

function specialCharsValidation(value, colname) {
	var bValid=true;
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?~_"; 
	for (var i = 0; i < value.length; i++) {
		if (iChars.indexOf(value.charAt(i)) != -1) {
			bValid=false;
			break;
		}
	}
	if (!bValid) 
	   return [false,colname+" cannot have any special characters"];
	else 
	   return [true,""];
}	

function dtstr() {
	var dt = new Date()
	return dt.getMonth()+'/'+dt.getDay()+'/'+dt.getFullYear()+ ' '+ dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds();
}

var getRowID = function(el) {
    return $(el).parents("tr").attr("id");
};

function ArrayToOptions($val, $sel) {
	if ($sel==null) {
		$sel=0;
	}
	var outOptions='';
	var i=0;
	var keys = Object.keys($val);

	for (var i = 0; i<keys.length; i++ ) {
		outOptions+='<option'+ ((i==0) ? ' selected="selected"' : '') + ' value="'+keys[i]+'">'+$val[keys[i]]+'</option>';
	}
	return outOptions;
}

function ArrayToOptionsDesc($val, $sel) {
	var outOptions='';
	var i=0;
	var keys = Object.keys($val);
	if ($sel==null) {
		$sel=0;
	}
	if ($sel==0) {
		outOptions+='<option'+ ((selected) ? ' selected="selected"' : '') + ' value="'+keys[0]+'">'+$val[keys[0]]+'</option>';
	}

	for (var i = keys.length; i>0; i-- ) {
		if ($val[keys[i]] != undefined) {
			var selected=((i==$sel) || ($sel==$val[keys[i]]));
			outOptions+='<option'+ ((selected) ? ' selected="selected"' : '') + ' value="'+keys[i]+'">'+$val[keys[i]]+'</option>';
		}
	}
	return outOptions;
}

function ObjectArrayToOptions($val, $sel, textField, valueField) {
	var outOptions='';
	var i=0;
	if ($sel==null) {
		$sel=0;
	}
	for (var i = 0; i<$val.length; i++ ) {
		var val=$val[i][textField];
		var text=$val[i][valueField];
		if (val != undefined) {
			if (($sel==0) && (val==0)) {
				outOptions = '<option'+ ((selected) ? ' selected="selected"' : '') + ' value="'+val+'">'+text+'</option>'+outOptions;
			} else {
				var selected=((val==$sel) || ($sel==text));
				outOptions+='<option'+ ((selected) ? ' selected="selected"' : '') + ' value="'+val+'">'+text+'</option>';
			}
		}
	}
	return outOptions;
}

(function($) {
  // Naive method of yanking the querystring portion from a string (just splits on the first '?', if present).
  function extractQuery(string) {
    if(string.indexOf('?') >= 0) {
      return string.split('?')[1];
    } else if(string.indexOf('=') >= 0) {
      return string;
    } else {
      return '';
    }
  };

  // Returns the JavaScript value of a querystring parameter.
  // Decodes the string & coerces it to the appropriate JavaScript type.
  // Examples:
  //    'Coffee%20and%20milk' => 'Coffee and milk'
  //    'true' => true
  //    '21' => 21
  function parseValue(value) {
    value = decodeURIComponent(value);
    try {
      return JSON.parse(value);
    } catch(e) {
      return value;
    }
  }

  // Takes a URL (or fragment) and parses the querystring portion into an object.
  // Returns an empty object if there is no querystring.
  function parse(url) {
    var params = {},
        query = extractQuery(url);

    if(!query) {
      return params;
    }

    $.each(query.split('&'), function(idx, pair) {
      var key, value, oldValue;
      pair = pair.split('=');
      key = pair[0].replace('[]', ''); // FIXME
      value = parseValue(pair[1] || '');
      if (params.hasOwnProperty(key)) {
        if (!params[key].push) {
          oldValue = params[key];
          params[key] = [oldValue];
        }
        params[key].push(value);
      } else {
        params[key] = value;
      }
    });

    return params;
  };

  // Takes an object and converts it to a URL fragment suitable for use as a querystring.
  function serialize(params) {
    var pairs = [], currentKey, currentValue;

    for(key in params) {
      if(params.hasOwnProperty(key)) {
        currentKey = key;
        currentValue = params[key];

        if(typeof currentValue === 'object') {
          for(subKey in currentValue) {
            if(currentValue.hasOwnProperty(subKey)) {
              // If subKey is an integer, we have an array. In that case, use `person[]` instead of `person[0]`.
              pairs.push(currentKey + '[' + (isNaN(subKey, 10) ? subKey : '') + ']=' + encodeURIComponent(currentValue[subKey]));
            }
          }
        } else {
          pairs.push(currentKey + '=' + encodeURIComponent(currentValue));
        }
      }
    }

    return pairs.join("&");
  };

  // Public interface.
  $.querystring = function(param) {
    if(typeof param === 'string') {
      return parse(param);
    } else {
      return serialize(param);
    }
  };

  // Adds a method to jQuery objects to get & querystring.
  //  $('#my_link').querystring(); // => {name: "Joe", job: "Plumber"}
  //  $('#my_link').querystring({name: 'Jack'}); // => Appends `?name=Jack` to href.
  $.fn.querystring = function() {
    var elm = $(this),
        existingData,
        newData = arguments[0] || {},
        clearExisting = arguments[1] || false;

    if(!elm.attr('href')) {
      return;
    }

    existingData = parse(elm.attr('href'));

    // Get the querystring & bail.
    if(arguments.length === 0) {
      return existingData;
    }

    // Set the querystring.
    if(clearExisting) {
      existingData = newData;
    } else {
      $.extend(existingData, newData);
    }
    elm.attr('href', elm.attr('href').split("?")[0] + "?" + serialize(existingData));
    return elm;

  };

})(jQuery);

var parseQueryString = function( queryString, qsParmToReturn ) {
	if (!queryString) queryString=window.location.search.replace('?', '');
    var params = {}, queries, temp, i, l;
 
    // Split into key/value pairs
    queries = queryString.split("&");
 
    // Convert the array of strings into an object
    for ( i = 0, l = queries.length; i < l; i++ ) {
        temp = queries[i].split('=');
        params[temp[0]] = temp[1];
    }
    if (qsParmToReturn) {
    	return ((params[qsParmToReturn]) ? params[qsParmToReturn] : null);
    	if (params[qsParmToReturn]) return params[qsParmToReturn]
    } else {
        return params;
    }
};

var QueryString = function(parmToFetch) {
	return parseQueryString(window.location.search.replace('?', ''), parmToFetch);
}

//Jquery Query string function

jQuery.fn.ForceNumericOnly =
	function()
	{
	    return this.each(function()
	    {
	        $(this).keydown(function(e)
	        {
	            var key = e.charCode || e.keyCode || 0;
	            // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
	            return (
	                key == 8 || 
	                key == 9 ||
	                key == 46 ||
	                (key >= 37 && key <= 40) ||
	                (key >= 48 && key <= 57) ||
	                (key >= 96 && key <= 105));
	        });
	    });
	};

	
	/* http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript 
	decimal_sep: character used as deciaml separtor, it defaults to '.' when omitted
	thousands_sep: char used as thousands separator, it defaults to ',' when omitted
	*/
	function toMoney(num, decimals, decimal_sep, thousands_sep)
	{ 
	   var n = num,
	   c = isNaN(decimals) ? 2 : Math.abs(decimals), //if decimal is zero we must take it, it means user does not want to show any decimal
	   d = decimal_sep || '.', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

	   /*
	   according to [http://stackoverflow.com/questions/411352/how-best-to-determine-if-an-argument-is-not-sent-to-the-javascript-function]
	   the fastest way to check for not defined parameter is to use typeof value === 'undefined' 
	   rather than doing value === undefined.
	   */   
	   t = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

	   sign = (n < 0) ? '-' : '',

	   //extracting the absolute value of the integer part of the number and converting to string
	   i = parseInt(n = Math.abs(n).toFixed(c)) + '', 

	   j = ((j = i.length) > 3) ? j % 3 : 0; 
	   return sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ''); 
	}	