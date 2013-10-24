console.log('break1');

function openAdvertDropPage(){
    console.log('BEGIN: openAdvertDropPage()');
	window.scrollTo(0,0);
 	$("#advertising").addClass('del123');
    $("#lightboxB, #advertising").animate({top:'0'},300);
    $("#lightboxB").fadeIn(0);
	return false;
 }

function openContactDropPage(){
    console.log('BEGIN: openContactDropPage()');
	window.scrollTo(0,0);
	$("#contactus").addClass('del123');
  $("#lightboxB, #contactus").animate({top:'0'},300);
  $("#lightboxB").fadeIn(0);
}

function openAboutDropPage(){
    console.log('BEGIN: openAboutDropPage()');
	window.scrollTo(0,0);
 	$("#aboutUs").addClass('del123');
    $("#lightboxB, #aboutUs").animate({top:'0'},300);
    $("#lightboxB").fadeIn(0);
}

function closeAdvertDropPage(){
	console.log('closeAdvertDropPage');
	 $("#lightboxB,").fadeOut(300);
	 $("#advertising").animate({top:'-800px'},300);
}

function closeContactDropPage(){
	console.log('closeContactDropPage');
	 $("#lightboxB,").fadeOut(300);
	 $("#contactus").animate({top:'-800px'},300);
}

function closeAboutDropPage(){
	console.log('closeAboutDropPage');
	 $("#lightboxB,").fadeOut(300);
	 $("#aboutUs").animate({top:'-800px'},300);
}

function lightboxBClick(){
	$("#aboutUs,#advertising,#contactus").removeClass('del123');
	$("#lightboxB").fadeOut(0);
	$("#aboutUs,#advertising,#contactus").animate({top:'-800px'},300);
}

function closeDropPages(){
	lightboxBClick();
}


function getCurrentHistoryStateDataForDropPage(){
	var state = History.getState();
	if (state && state.data && state.data.dropPage)
		return state.data.dropPage;
	else
    	return null;
}

function getCurrentHistoryStateDataForIpadContent(){
	var state = History.getState();
	if (state && state.data && state.data.ipadContent)
		return state.data.ipadContent;
	else
    	return null;
}

function stringContainsSubstring(haystack, needle){
	return haystack.indexOf(needle) !== -1;
}

function userIsOnIndexPhpPage(){
	if ( stringContainsSubstring(document.URL, "index.php") )
            return true;
	else
	    return false;
}

//these functions are meant to be wrappers/interfaces (for subsequent functions) that History.js calls with a params object
function historyLoadStateSchoolsToIpadContent(params){
	// expected params: stateAbbrev
	var stateAbbrev = params.stateAbbrev || '';
	if (!stateAbbrev){
		console.log('historyLoadStateSchoolsToIpadContent - FAIL');
		return;
	}
	loadStateSchoolsToIpadContent(stateAbbrev);
}

function historyLoadStatesMapToIpadContent(params){
	if (! userIsOnIndexPhpPage()){
		console.log('not on index.php');
		window.location.href = "https://www.universityvalues.com/index.php";
	} else {
		console.log('on index.php');
		loadStatesMapToIpadContent();
	}
}

function historyLoadCouponsForSchool(params){
	// expected params: stateAbbrev, schoolID
	var stateAbbrev = params.stateAbbrev || '';
	var schoolID = params.schoolID || '';
	if (!stateAbbrev || !schoolID){
		console.log('historyLoadCouponsForSchool - FAIL');
		return;
	}
	selectedState = stateAbbrev;
	loadCouponsForSchool(schoolID);
}

function historyLoadCouponDetails(params){
	// expected params: stateAbbrev, schoolID, couponID
	var couponID = params.couponID || '';
	var stateAbbrev = params.stateAbbrev || '';
	var schoolID = params.schoolID || '';
	if (!stateAbbrev || !schoolID || !couponID){
		console.log('historyLoadCouponDetails - FAIL');
		return;
	}
	selectedState = stateAbbrev;
	selectedSchool = schoolID;
	loadCouponDetails(couponID);
}

// pushState functions to reduce code & possible error when doing History.pushState() for ipadContent changes
function historyPushLoadSchoolsForStateWithAbbrev(stateAbbrev){
	History.pushState({
        'dropPage':getCurrentHistoryStateDataForDropPage(),
    	'ipadContent':{
			'func':'historyLoadStateSchoolsToIpadContent',
			'params':{
				'stateAbbrev':stateAbbrev
			}
        }
    }, document.title, '');
}

function historyPushLoadStatesMap(){
	History.pushState({
        'dropPage':getCurrentHistoryStateDataForDropPage(),
    	'ipadContent':{
			'func':'historyLoadStatesMapToIpadContent',
			'params':null
        }
    }, document.title, '');
}

function historyPushLoadCouponListForSchoolWithID(schoolID){
	schoolID = schoolID || selectedSchool;
	History.pushState({
        'dropPage':getCurrentHistoryStateDataForDropPage(),
    	'ipadContent':{
			'func':'historyLoadCouponsForSchool',
			'params':{
				'stateAbbrev':selectedState,
				'schoolID':schoolID
			}
        }
    }, document.title, '');
}

function historyPushLoadCouponDetailsForCouponWithID(couponID){
	History.pushState({
        'dropPage':getCurrentHistoryStateDataForDropPage(),
    	'ipadContent':{
			'func':'historyLoadCouponDetails',
			'params':{
				'stateAbbrev':selectedState,
				'schoolID':selectedSchool,
				'couponID':couponID
			}
        }
    }, document.title, '');
}

console.log('break2');

$(function() {

	console.log('in document.ready');
	
    // Prepare
    var History = window.History; // Note: We are using a capital H instead of a lower h
    console.log('initialized History object');
    if ( !History.enabled ) {
         console.log('History.js is disabled for this browser.');
         // This is because we can optionally choose to support HTML4 browsers or not.
        return false;
    }
	console.log('after History not enabled check');
    

    // Bind to StateChange Event
    History.Adapter.bind(window,'statechange',function() { // Note: We are using statechange instead of popstate
        console.log('BEGIN: History.js statechange');
        var state = History.getState();
        console.log('state = ' + JSON.stringify(state));
        if (state && state.data){
            if (state.data.dropPage && state.data.dropPage.func && window[state.data.dropPage.func]){
            	console.log('statechange: passed state dropPage test');
        		window[state.data.dropPage.func]();
            }
            if (state.data.ipadContent){
            	console.log('statechange: passed state ipadContent test');
				// do stuff for ipad content
				var params = null;
				if (state.data.ipadContent.params)
					params = state.data.ipadContent.params;
				if (state.data.ipadContent.func && window[state.data.ipadContent.func])
					window[state.data.ipadContent.func](params);
            }
        }
    });

    console.log('after history adapter bind');
    
	console.log('History.js replaceState()');

    $('a.openAdvert').click(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        History.replaceState({
        	'dropPage':{'func':'closeAdvertDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, '');
        History.pushState({
        	'dropPage':{'func':'openAdvertDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, ''); // alternatively, $(this).text() as title // also alternatively, $(this).attr('href') for third argument (url)
        //openAdvertDropPage();
    });

    $('a.openContact').click(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        History.replaceState({
        	'dropPage':{'func':'closeContactDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, '');
        History.pushState({
        	'dropPage':{'func':'openContactDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, ''); // alternatively, $(this).text() as title // also alternatively, $(this).attr('href') for third argument (url)
        //openContactDropPage();
    });

    $('a.openAbout').click(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        History.replaceState({
        	'dropPage':{'func':'closeAboutDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, '');
        History.pushState({
            'dropPage':{'func':'openAboutDropPage'},
        	'ipadContent':getCurrentHistoryStateDataForIpadContent()
        }, document.title, ''); // alternatively, $(this).text() as title // also alternatively, $(this).attr('href') for third argument (url)
        //openAboutDropPage();
    });

    $('a#closeContact').click(function(evt) {
    	evt.preventDefault();
    	History.back();
    });

    $('a#closeAbout').click(function(evt) {
    	evt.preventDefault();
    	History.back();
    });

    $('a#closeAdvert').click(function(evt) {
    	evt.preventDefault();
    	History.back();
    });
    
    // display the green tabs at the top right now that their on click listeners are set
    console.log('DROPPAGE: show()');
    $('.dropPage').show();
	
    // Set Default History State for Main Page
    var ipadContentStateData;
    if (userIsOnIndexPhpPage())
        ipadContentStateData = {'func':'historyLoadStatesMapToIpadContent'}
    else
        ipadContentStateData = null;
    
    History.replaceState({
    	'dropPage':{'func':'closeDropPages'},
    	'ipadContent':ipadContentStateData
    });
});

