<?php include_once('getContent.php'); ?>
<?php $state = $_GET['state']; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=310145085745476";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <script type="text/javascript" src="js/buttons.js"></script>
    <script type="text/javascript">
        (function() {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        })();
    </script>
    <script>
        !function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = "//platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, "script", "twitter-wjs");
    </script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $title ?></title>
    <?php if ($front == 1) { ?>
        <link href="../css/map.css" rel="stylesheet">
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="css/ie.css" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/tablet.css" />
    <link rel="stylesheet" type="text/css" href="css/ad-box.css" />
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" href="css/ie.css" />
    <![endif]-->
    <script type="text/javascript" src="html2canvas/html2canvas.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js"></script>

    <script type="text/javascript" src="js/history/native.history.js"></script>
    <script type="text/javascript" src="js/history-drop_pages_and_coupons.js"></script>
    <!-- <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script> -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.9.1.min.js"></script> -->
    <!-- <script type="text/javascript" src="js/jquery.maskedinput.js"></script> -->
    <script type="text/javascript">
        var schoolIDList = new Array();



        function applyToAllSchools(div) {
            var sid = div.id.substr(24);
            if ($("#CP" + sid + "1").attr("checked"))
                campaignID = 1;
            if ($("#CP" + sid + "2").attr("checked"))
                campaignID = 2;
            if ($("#CP" + sid + "3").attr("checked"))
                campaignID = 3;
            if ($("#CT" + sid + "2").attr("checked"))
                typeID = 2;
            if ($("#CT" + sid + "1").attr("checked"))
                typeID = 1;
            if ($("#CT" + sid + "3").attr("checked"))
                typeID = 3;
            for (var i = 0; i < schoolIDList.length; i++) {
                $("#CP" + schoolIDList[i] + campaignID).attr("checked", "checked");
                $("#CT" + schoolIDList[i] + typeID).attr("checked", "checked");
            }
        }



        $(document).ready(function() {
            //Set mask for phone number field
            $(".phoneNumber").mask("(999) 999-9999");
        });

        function getCouponImage()
        {
            var previewImage = document.getElementById('previewImage');
            previewImage.innerHTML = "";
            html2canvas($('#table1'), {allowTaint: true, taintTest: false,
                onrendered: function(canvas) {
                    previewImage.appendChild(canvas);
                    var dee = canvas.toDataURL("image/png");
                    document.getElementById('sorceCode').value = dee;
                }
            });

            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#preview_created_coupon").css({"left": "50%"});
            $("#preview_created_coupon").css({"position": "fixed"});
            $("#preview_created_coupon").css({"display": "block"});
            $("#preview_created_coupon").fadeIn(300);


            alert("Your coupon will appear in a few seconds. Click to proceed");
        }

        function validateFormGetCouponImageAndSubmitForm() {
            console.log('BEGIN: validateFormGetCouponImageAndSubmitForm()');
            if (validateTemplateCouponEditForm()){
                console.log('validate form: success');
                getCouponImageAndSubmitForm();
            } else {
                console.log('validate form: fail');
            }
        }

        function validateTemplateCouponEditForm() {
            var why = "";
//            var sorceCode = theform.sorceCode.value;
//            if (sorceCode == "") {
//                why += "-  Please upload all images and preview your coupon before clicking here to get final coupon.\n";
//            }
            var Ultimaite = $('#UltimaiteFormSelect').val();
            if (Ultimaite == "") {
                why += "-  Coupon redemptions allowed per mobile device every 6 months .\n";
            }
            var preview_offer = $('#preview_offer_form_text').val();
            if (preview_offer == null || preview_offer == "Example: ½ Off Your First Haircut!") {
                why += "-  Enter coupon preview offer.\n";
            }
            //var select = theform.select.value;
            //if (select == "") {
            //	why += "-  Please Select Participating Locations.\n";
            //}
            if (why != "") {
                alert(why);
                return false;
            } else {
                return true;
            }
        }
        
        function getCouponImageAndSubmitForm(){
            html2canvas($('#table1'), {allowTaint: true, taintTest: false,
                onrendered: function(canvas) {
                    var dee = canvas.toDataURL("image/png");
                    document.getElementById('sorceCode').value = dee;
                    $('#templateCouponEditForm').submit();
                }
            });
        }

        var oDoc, sDefTxt;
        function initDoc() {
            oDoc = document.getElementById("textBox1");
            sDefTxt = oDoc.innerHTML;
        }

        function formatDoc(sCmd, sValue) {
            if (validateMode())
            {
                document.execCommand(sCmd, false, sValue);
                oDoc.focus();
            }
        }

        function validateMode() {
            if (!document.compForm.switchMode.checked) {
                return true;
            }
            alert("Uncheck \"Show HTML\".");
            oDoc.focus();
            return false;
        }
        // changes green text box to white when selected
        function changeToWhite1() {
            document.getElementById("textBox1").style.background = "#FFFFFF";
        }
        function changeToWhite2() {
            document.getElementById("textBox2").style.background = "#FFFFFF";
        }
        function changeToWhite3() {
            document.getElementById("textBox3").style.background = "#FFFFFF";
        }
        function changeToWhite4() {
            document.getElementById("textBox4").style.background = "#FFFFFF";
        }

    </script>
<? if ($print == 1) { ?><link media="print" type="text/css" href="css/print.css" rel="stylesheet"><? } ?>
    <link href='https://fonts.googleapis.com/css?family=Waiting+for+the+Sunrise' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
    <script  type="text/javascript">
        function scroll() {
            window.scrollTo(0, 0);
        }
    </script>
    <script type="text/javascript">

        var schoolsSelected = new Array();
        var applyToAll = 0;
        var CT = "none";
        var AL = "none";
        var FBB = "none";
        var EM = "none";
        var AR = "none";
        var temp = '';
        var sid = '';


        function changeTheForm(sid, CT, AL, FBB, EM, AR)
        {
            $('input:radio[name="couponType[' + sid + ']"]:checked').val();
            $('#CT' + sid + '' + CT).attr('checked', true);
            $('#AL' + sid + '' + AL).attr('checked', true);
            changeAdverLength(sid, AL)
            $("#featureSelect" + sid).val(FBB);
            $("#editSelect" + sid).val(EM);
            if (AR == 1)
                $('#AR' + sid).attr('checked', true);
            else
                $('#AR' + sid).attr('checked', false);
        }
        function applyalltoschools(sid)
        {

            if ($('#applyall' + sid).is(":checked"))
            {
                $(".applyallhide").css({"display": "none"});
                $(".applied" + sid).css({"display": "block"});
                applyToAll = sid;

                CT = $('input:radio[name="couponType[' + sid + ']"]:checked').val();
                AL = $('input:radio[name="couponLength[' + sid + ']"]:checked').val();
                FBB = $("select#featureSelect" + sid).val();
                EM = $("select#editSelect" + sid).val();
                if ($('#AR' + sid).is(":checked"))
                    AR = '1';
                else
                    AR = 'none';

                for (i = 0; i < schoolsSelected.length; i++)
                {
                    if (i > 0 && schoolsSelected[i] != sid)
                    {
                        $('input:radio[name="couponType[' + i + ']"]:checked').val();
                        $('#CT' + schoolsSelected[i] + '' + CT).attr('checked', true);
                        $('#AL' + schoolsSelected[i] + '' + AL).attr('checked', true);
                        changeAdverLength(schoolsSelected[i], AL)
                        $("#featureSelect" + schoolsSelected[i]).val(FBB);
                        $("#editSelect" + schoolsSelected[i]).val(EM);
                        if (AR == 1)
                            $('#AR' + schoolsSelected[i]).attr('checked', true);
                        else
                            $('#AR' + schoolsSelected[i]).attr('checked', false);

                    }
                }

            }
            else {
                $(".applyallhide").css({"display": "block"});
                applToAll = 0;
            }






            for (i = 0; i < schoolsSelected.length; i++)
            {
            }

        }

        var tooltip = function() {
            var id = 'tt';
            var top = 3;
            var left = 3;
            var maxw = 300;
            var speed = 10;
            var timer = 20;
            var endalpha = 95;
            var alpha = 0;
            var tt, t, c, b, h;
            var ie = document.all ? true : false;
            return{
                show: function(v, w) {
                    if (tt == null) {
                        tt = document.createElement('div');
                        tt.setAttribute('id', id);
                        t = document.createElement('div');
                        t.setAttribute('id', id + 'top');
                        c = document.createElement('div');
                        c.setAttribute('id', id + 'cont');
                        b = document.createElement('div');
                        b.setAttribute('id', id + 'bot');
                        tt.appendChild(t);
                        tt.appendChild(c);
                        tt.appendChild(b);
                        document.body.appendChild(tt);
                        tt.style.opacity = 0;
                        tt.style.filter = 'alpha(opacity=0)';
                        document.onmousemove = this.pos;
                    }
                    tt.style.display = 'block';
                    c.innerHTML = v;
                    tt.style.width = w ? w + 'px' : 'auto';
                    if (!w && ie) {
                        t.style.display = 'none';
                        b.style.display = 'none';
                        tt.style.width = tt.offsetWidth;
                        t.style.display = 'block';
                        b.style.display = 'block';
                    }
                    if (tt.offsetWidth > maxw) {
                        tt.style.width = maxw + 'px'
                    }
                    h = parseInt(tt.offsetHeight) + top;
                    clearInterval(tt.timer);
                    tt.timer = setInterval(function() {
                        tooltip.fade(1)
                    }, timer);
                },
                pos: function(e) {
                    var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
                    var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
                    tt.style.top = (u - h) + 'px';
                    tt.style.left = (l + left) + 'px';
                },
                fade: function(d) {
                    var a = alpha;
                    if ((a != endalpha && d == 1) || (a != 0 && d == -1)) {
                        var i = speed;
                        if (endalpha - a < speed && d == 1) {
                            i = endalpha - a;
                        } else if (alpha < speed && d == -1) {
                            i = a;
                        }
                        alpha = a + (i * d);
                        tt.style.opacity = alpha * .01;
                        tt.style.filter = 'alpha(opacity=' + alpha + ')';
                    } else {
                        clearInterval(tt.timer);
                        if (d == -1) {
                            tt.style.display = 'none'
                        }
                    }
                },
                hide: function() {
                    clearInterval(tt.timer);
                    tt.timer = setInterval(function() {
                        tooltip.fade(-1)
                    }, timer);
                }
            };
        }();
    </script>

    <script src="js/jsScrollbar.js"></script>
    <script language="javascript">

        var numberOn = 1;
        var img = new Image();
        var int = "";
        var imageObj = new Array();
        function logointerval()
        {
            var temp = "";
            for (i = 1; i < 56; i++)
            {
                temp = $('<img>');
                img.src = "animate/logo animated 5 f" + i + ".png";
                temp.attr("src", img.src)
                $('#preload').append(temp)
            }
            animatelogo();
        }
        function animatelogo()
        {
            if (!document.getElementById('anilogo'))
                return;
            img = '<img src="animate/logo animated 5 f' + numberOn + '.png">';
            document.getElementById('anilogo').innerHTML = img;
            numberOn++;
            if (numberOn != 56)
            {
                setTimeout(animatelogo, 75);
            }
        }



        var requireLeft = 100;

        $(document).ready(function()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});

            $(".defaultText").focus(function(srcc)
            {
                if ($(this).val() == $(this)[0].title)
                {
                    $(this).val("");
                }
            });

            $(".defaultText").blur(function()
            {
                if ($(this).val() == "")
                {
                    $(this).val($(this)[0].title);
                }
            });

            $(".defaultText").blur();

            $(".emailCheck").blur(function()
            {
                if ($(this).val() != 'Email' && isValidEmailAddress($(this).val()) == false)
                    alert('This does not appear to be a valid email. Please try again.');

            });

        });
<?php if ($setlocation == "1") { ?>
            if (navigator && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(geo_success, geo_error);
            } else {
                error('Geolocation is not supported.');
            }<?php } ?>
        function checkSignup(sess) {
            if (sess == 0) {
                $('#signupForm').submit();
            } else {
                requireLeft = 7;
                $('.requiredText').each(function() {
                    if ($(this).val() != $(this)[0].title && $(this).val() != '') {
                        requireLeft -= 1;
                    }
                });

                if (requireLeft > 0) {
                    if (document.getElementById('password2a_input').value != document.getElementById('password2b_input').value) {
                        alert("Password fields must match");
                    } else {
                        error = '';
                        if (document.getElementById('existingEmail').value == ''
                                || document.getElementById('existingEmail').value == 'Email'
                                || isValidEmailAddress(document.getElementById('existingEmail').value) == false)
                            error += "\nValid email is required";
                        if (document.getElementById('firstName').value == "" || document.getElementById('firstName').value == "First Name")
                            error += "\nFirst name is required";
                        if (document.getElementById('lastName').value == "" || document.getElementById('lastName').value == "Last Name")
                            error += "\nLast name is required";
                        if (document.getElementById('businessB').value == "" || document.getElementById('businessB').value == "Business Name")
                            error += "\nBusiness name is required";
                        if (document.getElementById('phoneB').value == "" || document.getElementById('phoneB').value == "Phone")
                            error += "\nPhone is required";
                        if (document.getElementById('city').value == "" || document.getElementById('city').value == "City")
                            error += "\nCity is required";
                        if (document.getElementById('state').value == "" || document.getElementById('state').value == "State")
                            error += "\nState is required";
                        if (document.getElementById('zip').value == "" || document.getElementById('zip').value == "Zip")
                            error += "\nZip is required";

                        if (error > "")
                            alert("The following errors were found:\n\n" + error);
                        else
                            $('#signupForm').submit();
                    }
                } else
                    $('#signupForm').submit();
            }
        }
        function geo_success(position) {
            printLatLong(position.coords.latitude, position.coords.longitude);
        }
        // The PositionError object returned contains the following attributes:
        // code: a numeric response code
        // PERMISSION_DENIED = 1
        // POSITION_UNAVAILABLE = 2
        // TIMEOUT = 3
        // message: Primarily for debugging. It's recommended not to show this error
        // to users.
        function geo_error(err) {
            if (err.code == 1) {
                error('The user denied the request for location information.')
            } else if (err.code == 2) {
                error('Your location information is unavailable.')
            } else if (err.code == 3) {
                error('The request to get your location timed out.')
            } else {
                error('An unknown error occurred while requesting your location.')
            }
        }

        // output lat and long
        function printLatLong(lat, long) {
            //$.post("saveLocation.php?lat="+lat+"&long="+long, function() {
            //	// do something on response
            //})
        }

        function error(msg) {

        }
        function deleteSchool(theid)
        {
            $("#newSchool" + theid).fadeOut(500);
            $("#newSchool" + theid).remove();
            SchoolsCnt = SchoolsCnt - 1;
            if (SchoolsCnt == 0)
                $("#signupFormHide").fadeOut(500);
            else if (SchoolsCnt == 1)
                $('.applyallhide').css({"display": "none"});
        }
        function toggleOptions(theid)
        {
            $("#couponOptions" + theid).toggle(1);
            var tempV = $("#arrow" + theid)[0].title;
            var tempS = $("#arrow" + theid)[0].src;
            $("#arrow" + theid).attr("src", tempV);
            $("#arrow" + theid).attr("title", tempS);
        }

        function validateCheckoutAndCartForm() {
            var shouldSubmit = false;
            // billing info (personal info)
            if ($("#billingName").val() == 'Name' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Name is required to continue.');
            else if ($("#billingCompany").val() == 'Business' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Business is required to continue.');
            else if ($("#billingEmail").val() == 'Email' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Email is required to continue.');
            else if ($("#billingPhone").val() == 'Phone' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Phone is required to continue.');
            else if ($("#billingAddress").val() == 'Address' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Address is required to continue.');
            else if ($("#billingCity").val() == 'City' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing City is required to continue.');
            else if ($("#billingZip").val() == 'Zip' || $("#billingName").val() == '')
                return falseAndAlertSomeText('Billing Zip is required to continue.');
            else if ($("#useremail").val() == 'User Email' || $("#useremail").val() == '')
                return falseAndAlertSomeText('User Email is required to continue.');
            else if (!$("#agreeTo").is(':checked'))
                return falseAndAlertSomeText('You must agree to the terms and conditions.');

            // card-specific
            if ($('#complete1').is(':checked')) {
                if ($("#name_Card").val() == 'Name on Card' || $("#name_Card").val() == '')
                    return falseAndAlertSomeText('Billing Card Name is required to continue.');
                else if ($("#card_Mumner").val() == 'Card Number' || $("#card_Mumner").val() == '')
                    return falseAndAlertSomeText('Billing Card Number is required to continue.');

                else if ($("#cardMonth").val() == '')
                    return falseAndAlertSomeText('Billing Card expiration month is required to continue.');

                else if ($("#cardYear").val() == '')
                    return falseAndAlertSomeText('Billing Card expiration year is required to continue.');

                else if ($("#csv").val() == 'CSV' || $("#csv").val() == '')
                    return falseAndAlertSomeText('Billing Card csv is required to continue.');
            } else if ($('#complete2').is(':checked')) {

                // echeck-specific
                if ($("#routingNumber").val() == 'Routing Number' || $("#routingNumber").val() == '')
                    return falseAndAlertSomeText('Billing  routing number is required to continue.');

                else if ($("#accountNumber").val() == 'Account Number' || $("#accountNumber").val() == '')
                    return falseAndAlertSomeText('Billing account number is required to continue.');
            }
            // not on the form at the moment
            if ($("#salesRep").val() == 'Select' || $("#salesRep").val() == '')
                return falseAndAlertSomeText('"Who Helped You" is required to continue.');

<?php
// the password creation is now being done on the page prior
//if ($_GET['ref'] == 'signup') {
//    echo " else if($('#password_input').val()== '')
//                    alert('A Password is required to continue.');
//                    else if($('#password_input').val() != $('#password_inputc').val())
//                    alert('Your Passwords do not match. Please try again.'); ";
//}
?>

            return true;
        }

        function falseAndAlertSomeText(text) {
            alert(text);
            return false;
        }

        function changeTheSchoolb(name)
        {
            var school = name.split("~");
            $("#theschool" + school[0]).fadeOut(500);
            var newDiv = "<div id='#newSchool" + school[0] + "' style=''><input style='width:20px;' type=checkbox value=" + school[0] + " name='realSelected' CHECKED> " + school[1] + "<br/></div>";
            var currentHTML = $('#couponBuy').html();
            $('#couponBuy').append(newDiv);
            $("#newSchool" + school[0]).fadeIn(500);

        }
        var SchoolsCnt = 0;

        function changeAdverLength(name, thelength)
        {
            var fff = "#featureSelect" + name;
            var eee = '#editSelect' + name;

            $(fff + ' option:gt(0)').remove();
            $(eee + ' option:gt(0)').remove();

            $(fff).append($("<option></option>").attr("value", 6).text("6 Months"));
            $(eee).append($("<option></option>").attr("value", 6).text("6 Updates"));

            if (thelength > 6)
            {
                $(fff).append($("<option></option>").attr("value", 12).text("12 Months"));
                $(eee).append($("<option></option>").attr("value", 12).text("12 Updates"));
            }

            if (thelength > 12)
            {
                $(fff).append($("<option></option>").attr("value", 24).text("24 Months"));
                $(eee).append($("<option></option>").attr("value", 24).text("24 Updates"));
            }
        }
        function changeTheSchool(name, monthlyEditTooltipText, featuredBusinessTooltipText)
        {
            monthlyEditTooltipText = monthlyEditTooltipText || "Monthly Edit Tooltip Text";
            featuredBusinessTooltipText = featuredBusinessTooltipText || "Featured Business Tooltip Text";
            //console.log('BEGIN: changeTheSchool() - monthlyEditTooltipText = ' + monthlyEditTooltipText + ', featuredBusinessTooltipText = ' + featuredBusinessTooltipText);
            var school = name.split("~");
            $("#theschool" + school[0]).fadeOut(1000);

            var newDiv = "<div id='newSchool" + school[0] + "' class='schoolDiv' style='display:none;'><div  onClick='toggleOptions(" + school[0] + ");'><input type=hidden name='couponSchool[]' value='" + school[0] + "'><span class='schoolName'>" + school[1] + "</span>&nbsp;&nbsp;<a class='removeSchool' onClick='deleteSchool(" + school[0] + ")'>Delete School</a><img id='arrow" + school[0] + "' title='images/arrowDown.png' src='images/upArrow.png' style='float:right; margin-top:10px;'></a><img src='images/pageBreaker.png' width=847></div>";

            newDiv = newDiv + "<div class='couponOptions' id='couponOptions" + school[0] + "'>";

            newDiv = newDiv + "<div class='couponPlans' id='couponPlans" + school[0] + "'>";
            newDiv = newDiv + "<span class='funky green uppercase' style='font-size:1.7em; font-weight:bold;'>Select Your Student Advertising Campaign</span> <span class='thegray'></span><br/>";

            newDiv = newDiv + "<table style=\"font-family:'Arial';margin-top:13px; border-collapse: separate; border-spacing: 10px 5px; width:100%;\">";
            newDiv = newDiv + "<tr>";
            newDiv = newDiv + "                <td align='center'>";

            newDiv = newDiv + "<map name=\"associatesLargeIphoneMap" + school[0] + "\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"85,455, 225,470\" onclick=\"uvcoupon();\" href=\"javascript:;\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"75,425, 220,440\" onclick=\"createcoupon();\" href=\"javascript:;\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"75,400, 220,415\" onclick=\"couponCenter();\" href=\"javascript:;\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"210,380, 225,390\" onmouseover=\"tooltip.show('" + monthlyEditTooltipText + "', 200);\" onmouseout=\"tooltip.hide();\">";
            newDiv = newDiv + "</map>";

            newDiv = newDiv + "<map name=\"bachelorsLargeIphoneMap" + school[0] + "\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"190,420, 210,435\" onmouseover=\"tooltip.show('" + monthlyEditTooltipText + "', 200);\" onmouseout=\"tooltip.hide();\">";
            newDiv = newDiv + "</map>";

            newDiv = newDiv + "<map name=\"mastersLargeIphoneMap" + school[0] + "\">";
            newDiv = newDiv + "<area shape=\"rect\" coords=\"175,380, 190,395\" onmouseover=\"tooltip.show('" + featuredBusinessTooltipText + "', 200);\" onmouseout=\"tooltip.hide();\">";
            newDiv = newDiv + "</map>";

            newDiv = newDiv + "<div id='CP" + school[0] + "Div1' style='width:280px; height:585px; position: relative;'>"; // background-image:url(\"images\/campaign_associates.png\");'>";
            newDiv = newDiv + "<label for='CP" + school[0] + "1'>";
            newDiv = newDiv + "<img usemap=\"#associatesLargeIphoneMap" + school[0] + "\" src='images\/campaign_associates.png' style='position: absolute; left:0px; top:0px;' />";
            newDiv = newDiv + "</label>";
            newDiv = newDiv + "<input id='CP" + school[0] + "1'  type='radio' name='couponProgram[" + school[0] + "]' value='1' style='width:auto; z-index:100;'/>";
            newDiv = newDiv + "<br />"; // Associates
            newDiv = newDiv + "</div>";
            newDiv = newDiv + "                </td>";
            newDiv = newDiv + "                <td align='center'>";
            newDiv = newDiv + "<div id='CP" + school[0] + "Div2' style='width:286px; height:585px; position: relative;'>"; // background-image:url(\"images\/campaign_bachelors.png\");'>";
            newDiv = newDiv + "<label for='CP" + school[0] + "2'>";
            newDiv = newDiv + "<img usemap=\"#bachelorsLargeIphoneMap" + school[0] + "\" src='images\/campaign_bachelors.png' style='position: absolute; left:0px; top:0px;' />";
            newDiv = newDiv + "</label>";
            newDiv = newDiv + "<input id='CP" + school[0] + "2'  type='radio' name='couponProgram[" + school[0] + "]' value='2' style='width:auto; z-index:100;' checked='checked' />";
            newDiv = newDiv + "<br />"; // Bachelors
            newDiv = newDiv + "</div>";
            newDiv = newDiv + "                </td>";
            newDiv = newDiv + "                <td align='center'>";
            newDiv = newDiv + "<div id='CP" + school[0] + "Div3' style='width:275px; height:585px; position: relative;'>"; // background-image:url(\"images\/campaign_masters.png\");'>";
            newDiv = newDiv + "<label for='CP" + school[0] + "3'>";
            newDiv = newDiv + "<img usemap=\"#mastersLargeIphoneMap" + school[0] + "\" src='images\/campaign_masters.png' style='position: absolute; left:0px; top:0px;' />";
            newDiv = newDiv + "</label>";
            newDiv = newDiv + "<input id='CP" + school[0] + "3'  type='radio' name='couponProgram[" + school[0] + "]' value='3' style='width:auto; z-index:100;'/>";
            newDiv = newDiv + "<br />"; // Masters
            newDiv = newDiv + "</div>";
            newDiv = newDiv + "                </td>";
            newDiv = newDiv + "</tr>";
            newDiv = newDiv + "</table>";
            newDiv = newDiv + "<br />";
            newDiv = newDiv + "<div style='float:right;'><small>*Additional charge for Custom Coupon Design.</small></div>";

            newDiv = newDiv + "</div>";
            newDiv = newDiv + "<br />";
            newDiv = newDiv + "        <hr width='100%'/>";

            newDiv = newDiv + "<span class='funky green uppercase' style='font-size:1.7em; font-weight:bold;'>Choose Your Coupon Type</span> <span class='thegray'></span><br/>";
            newDiv = newDiv + "        <table style=\"font-family:'Arial';margin-top:13px; border-collapse: separate; border-spacing: 10px 5px; width:100%;\">";
            newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td align='center'><input id='CT" + school[0] + "2'  type='radio' name='couponType[" + school[0] + "]' value='2' style='width:auto;' checked='yes'/></td>";	// width:20px;
            newDiv = newDiv + "                <td align='center'><input id='CT" + school[0] + "1' type='radio' name='couponType[" + school[0] + "]' value='1' style='width:auto;'/></td>"; //width:20px;
            newDiv = newDiv + "                <td align='center'><input id='CT" + school[0] + "3'  type='radio' name='couponType[" + school[0] + "]' value='3' style='width:auto;'/></td>"; //width:20px;
            newDiv = newDiv + "            </tr>";
            newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td align='center'><a  onClick='uvcoupon()' style='cursor:pointer;'><img src='images/uv_custom_coupon_design.png' border=0 /></a></td>";
            //newDiv = newDiv + "                <td>UV Custom Coupon Design ($<?= $prices[0][price] ?>)</td>";
            //newDiv = newDiv + "            </tr>";
            //newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td align='center'><a onClick='createcoupon()' style='cursor:pointer;'><img src='images/uv_coupon_creator_template.png' border=0 /></a></td>";
            //newDiv = newDiv + "               <td>Free Coupon Creator Template</td>";
            //newDiv = newDiv + "            </tr>";
            //newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td align='center'><img src='images/uv_upload_your_own_coupon.png' /></td>";
            //newDiv = newDiv + "                <td>Upload Your Own Predesigned Coupon</td>";
            newDiv = newDiv + "            </tr>";
            newDiv = newDiv + "        </table>";
            newDiv = newDiv + "        <hr width='100%'/>";
            // Until a function is made that enables this functionality, the "Apply To All Schools" button is removed
            newDiv = newDiv + "<div id='applyOptionsToAllSchoolsDiv' style='float:right;'>";
            newDiv = newDiv + "<input type='checkbox' name='applyOptionsToAllSchools" + school[0] + "' id='applyOptionsToAllSchools" + school[0] + "' value='Yes' style='width:auto; margin-right:10px;' onchange='applyToAllSchools(this)' >";
            newDiv = newDiv + "<label for='applyOptionsToAllSchools" + school[0] + "' class='thegray'>Apply selected options to all schools</label>";
            newDiv = newDiv + "</div>";

            // These last few options are outdated - they were used before "Coupon Programs" (Associates, Bachelors, and Masters) came around and superceded them
            newDiv = newDiv + "<span style='display:none; visibility; hidden; '>";
            newDiv = newDiv + "        <span class='funky green uppercase' style='font-size:1.7em; font-weight:bold;'>Advertising Length</span> <span class='thegray'>(select one)</span><br/>";
            newDiv = newDiv + "        <table style=font-family:'Arial';margin-top:13px;>";
            newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td valign=top><input id='AL" + school[0] + "6' type='radio' name='couponLength[" + school[0] + "]' value='6' style='width:20px;' onchange='changeAdverLength(" + school[0] + ",6)' /></td>";
            newDiv = newDiv + "                <td>6 Months ($<?= $prices[3][price] ?>)<br/><span class='smallgray'>- Includes one free coupon update.</span></td>";
            newDiv = newDiv + "            </tr>";
            newDiv = newDiv + "            <tr><td height='20'></td></tr>";
            newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td valign=top><input id='AL" + school[0] + "12' type='radio'  checked='yes' name='couponLength[" + school[0] + "]' value='12' style='width:20px;' onchange='changeAdverLength(" + school[0] + ",12)' /></td>";
            newDiv = newDiv + "                <td>12 Months ($<?= $prices[4][price] ?>)<br/><span class='smallgray'>- Includes two free coupon updates.</span></td>";
            newDiv = newDiv + "            </tr>";
            newDiv = newDiv + "            <tr><td height='20'></td></tr>";
            newDiv = newDiv + "            <tr>";
            newDiv = newDiv + "                <td valign=top><input id='AL" + school[0] + "24' type='radio' name='couponLength[" + school[0] + "]' value='24' style='width:20px;' onchange='changeAdverLength(" + school[0] + ",24)' /></td>";
            newDiv = newDiv + "                <td>24 Months ($<?= $prices[5][price] ?>)<br/><span class='smallgray'>- Includes four free coupon updates.</span></td>";
            newDiv = newDiv + "            </tr>";
            newDiv = newDiv + "        </table><br/>";
            newDiv = newDiv + "	<input id='AR" + school[0] + "' type=checkbox name=autorenew[" + school[0] + "] value=1 style='width:20px; margin-left:8px;'>Auto Renewal <a name='tooltip' class='autorenewtip' onmouseover=\"tooltip.show('<? getQuestions(1); ?>', 400);\" onmouseout=\"tooltip.hide();\">?</a>";
            newDiv = newDiv + "        <hr width='100%'/>";
            newDiv = newDiv + "        <span class='funky green uppercase' style='font-size:1.7em; font-weight:bold;'>Optional Features</span> <span class='thegray'>(select any)</span><br /><br />";
            newDiv = newDiv + "      <span><select style='width:97px'  id='featureSelect" + school[0] + "' name='feature[" + school[0] + "]'><option>Select</option><option value='6'>6 Months</option><option value='12'>12 Months</option></select></span> &nbsp; &nbsp; Feature Business ($<?= $prices[1][price] ?> Per 6 Months) <span><a name='tooltip' class='autorenewtip' onmouseover=\"tooltip.show('<?php echo getQuestions(6); ?>', 400);\" onmouseout='tooltip.hide();'>?</a></span><br/>";
            newDiv = newDiv + "        ";
            newDiv = newDiv + "        <br/><br/>";
            newDiv = newDiv + "        <span><select id='editSelect" + school[0] + "' name='monthlyEdit[" + school[0] + "]'><option>Select</option><option value='6'>6 Updates</option><option value='12'>12 Updates</option></select></span> &nbsp; &nbsp; Coupon Updates ($<?= $prices[2][price] ?> Per 6 Updates) <span><a name='tooltip' class='autorenewtip' onmouseover=\"tooltip.show('<?php echo getQuestions(7); ?>', 400);\" onmouseout='tooltip.hide();'>?</a></span><br/>";
            newDiv = newDiv + "        ";
            newDiv = newDiv + "	<div class='applyallhide applied" + school[0] + "'><hr width='100%'/><div style='float:left; margin-bottom:10px;'><input onchange=\"javascript:applyalltoschools(" + school[0] + ")\" id='applyall" + school[0] + "' type=checkbox  style='width:20px;' name=applyall value=" + school[0] + ">Apply selected options to all schools</div></div>";
            newDiv = newDiv + "</span>";
            newDiv = newDiv + "	<img src='images/pageBreaker.png' width=847>";
            newDiv = newDiv + "        ";
            newDiv = newDiv + "</div>";

            newDiv = newDiv + "</div>";
            var currentHTML = $('#couponBuy').html();
            $('#couponBuy').append(newDiv);
            $("#newSchool" + school[0]).fadeIn(500);

            SchoolsCnt = SchoolsCnt + 1;
            if (SchoolsCnt > 1)
                schoolsSelected[SchoolsCnt] = school[0];

            if (SchoolsCnt == 1)
            {
                var tempV = $("#arrow" + school[0])[0].title;
                var tempS = $("#arrow" + school[0])[0].src;
                $("#arrow" + school[0]).attr("src", tempV);
                $("#arrow" + school[0]).attr("title", tempS);
                $('.applyallhide').css({"display": "none"});
                $("#signupFormHide").fadeIn(500);
                //
            }
            else {
                $('.applyallhide').css({"display": "block"});
                $("#couponOptions" + school[0]).toggle(1);
            }
            schoolIDList.push(school[0]);

        }
        //-->
    </script>
    <script type="text/javascript">

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
            // alert( pattern.test(emailAddress) );
            return pattern.test(emailAddress);
        }
        ;

        $(document).ready(function() {

            //$(".phoneNumber").mask("(999) 999-9999");

            $("a#goButton").click(function() {
                var get_signup_emailid = document.getElementById("signup_Email").value;
                if ((get_signup_emailid == "Your Email") || (get_signup_emailid == "")) {
                    document.getElementById('invalidEmail').innerHTML = '<span class="invalid_email_warning">Please enter a valid email.</span>';
                    document.getElementById("signup_Email").focus();
                }
                else if (isValidEmailAddress(get_signup_emailid) == false)
                {
                    document.getElementById('invalidEmail').innerHTML = '<span class="invalid_email_warning">Please enter a valid email.</span>';
                    document.getElementById("signup_Email").focus();
                }
                else if (isValidEmailAddress(get_signup_emailid) == true) {
                    $.ajax({
                        type: 'GET',
                        url: 'TestSaveEmail.php',
                        data: {email: get_signup_emailid},
                        success: function(data) {
                            var get_response = data;
                            if (get_response == "error") {
                                document.getElementById('invalidEmail').innerHTML = '<span class="invalid_email_warning">Please enter a valid email.</span>';
                                document.getElementById("signup_Email").focus();
                            } else {
                                document.getElementById('invalidEmail').innerHTML = '<span class="invalid_email_succ">Thank you for subscribing!</span>';
                                document.getElementById("signup_Email").value = "Your Email";
                            }

                        }
                    });
                }
            });

            $("a#applyPromo").click(function() {
                var thepromo = document.getElementById("thePromoCode").value;
                var beforepromo = document.getElementById("beforePromo").value;

                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {

                        var afterpromo = xmlhttp.responseText;
                        document.getElementById("thetotal").innerHTML = afterpromo;



                    }
                }
                xmlhttp.open("GET", "getpromo.php?q=" + thepromo + "&t=" + beforepromo, true);
                xmlhttp.send();

            });


            $("a.templateExamples").live("click", function() {
                $("#lightbox").css({"height": $(document).height() + "px"});
                $("#lightbox").fadeIn(0);
                $("#freegallery-panel").fadeIn(0);
            });
            $("a.customExamples").live("click", function() {
                $("#lightbox").css({"height": $(document).height() + "px"});
                $("#lightbox").fadeIn(0);
                $("#customgallery-panel").fadeIn(0);
            });
            $("a#close-customgallery").live("click", function() {
                $("#customgallery-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });
            $("a#close-freegallery").live("click", function() {
                $("#freegallery-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });
            $("a#close-uvcouponsScreen").live("click", function() {
                $("#uvcouponsScreen-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });
            $("a#close-couponcenter").live("click", function() {
                $("#couponcenter-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });

            $("a.openTOS").click(function() {
                $("#lightbox").fadeIn(0);
                $("#TOS-panel").fadeIn(300);
            });
            $("a#close-TOS").click(function() {
                $("#TOS-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });
            $("a.openAATOS").click(function() {
                $("#lightbox").fadeIn(0);
                $("#AATOS-panel").fadeIn(300);
            });
            $("a#close-AATOS").click(function() {
                $("#AATOS-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });


            $("a.guidelines").click(function() {
                $("#lightbox").fadeIn(0);
                $("#guidelines-panel").fadeIn(300);
            });
            $("a#close-AATOS").click(function() {
                $("#guidelines-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });


            $("a.openPrivacy").click(function() {
                $("#lightbox").fadeIn(0);
                $("#privacy-panel").fadeIn(300);
            });
            $("a#close-privacy").click(function() {
                $("#privacy-panel").fadeOut(300);
                $("#lightbox").fadeOut(300);
            });
            $("a.checkoutButton").click(function() {
                var isChecked = $("#agreeTo").prop('checked');

                if (isChecked == false)
                {
                    alert('You must agree to the terms and condition to proceed to checkout.');
                    //$("#mustAgree").css({"display":"block"});
                }
                else
                {
                    $("#cartform").submit();
                }
            });

            $("a#finishCheckout").click(function() {

                if (validateCheckoutAndCartForm())
                    $("#checkoutFrom").submit();

            });

            $('#clear').focus(function() {
                $('#clear').hide();
                $('#password_input').show().focus();
            });

            $('#clearb').focus(function() {
                $('#clearb').hide();
                $('#password_inputb').show().focus();
            });

            $('#clearc').focus(function() {
                $('#clearc').hide();
                $('#password_inputc').show().focus();
            });

            $('#password_input').blur(function() {
                if ($('#password_input').val() == '' || $('#password_input').val() == 'Password') {
                    $('#clear, #password_input').toggle();
                }
            });

            $('#password_inputb').blur(function() {
                if ($('#password_inputb').val() == '' || $('#password_inputb').val() == 'Password') {
                    $('#clearb, #password_inputb').toggle();
                }
            });

            $('#password_inputc').blur(function() {
                if ($('#password_inputc').val() == '' || $('#password_inputc').val() == 'Confirm Password') {
                    $('#clearc, #password_inputc').toggle();
                }

            });


            $("#lightboxB").click(function() {
                //lightboxBClick();
                History.back();
            });

            $(".clientsSaying").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#testimonials-panel").fadeIn(300);

            });


            $(".example").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#Example").fadeIn(300);

            });

            $("a#close-example,#lightbox").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#Example").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                    $("#Example").fadeOut(300);
                }
                else {
                    $("#lightbox").fadeOut(300);
                    $("#Example").fadeOut(300);

                }


            });



            $(".Example_uv_coupon").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#Example_uv_coupon").fadeIn(300);

            });

            $("a#close-example,#lightbox").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#Example_uv_coupon").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {
                    $("#lightbox").fadeOut(300);

                }


            });
            $(".Example_create_coupon").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#Example_create_coupon").fadeIn(300);

            });

            $("a#close-example,#lightbox").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#Example_create_coupon").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {
                    $("#lightbox").fadeOut(300);

                }


            });

            $(".preview_created_coupon").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#preview_created_coupon").fadeIn(300);

            });

            $("a#close-preview").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#preview_created_coupon").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {
                    $("#lightbox").fadeOut(300);

                }


            });



            $(".privivecoupons").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#Privivecoupons").fadeIn(300);

            });

            $("a#close-example").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#Privivecoupons").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {
                    $("#lightbox").fadeOut(300);

                }


            });



            $(".appTutorial").click(function() {
                if ($('#lightbox').is(':visible') == true)
                {
                    $("#lightbox").css({"z-index": "10000"});
                }
                else
                {
                    $("#lightbox").fadeIn(0);
                }
                $("#appTutorial-panel").fadeIn(300);

            });




            $("div#lightbox").click(function() {
                var zindex = $("#lightbox").css("z-index");
                if (zindex == 10000)
                {
                    $("#testimonials-panel").fadeOut(300);
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {

                    $("#lightbox,").fadeOut(300);
                    $("#advertising,#aboutUs,#contactus").animate({top: '-800px'}, 300);
                    $("#testimonials-panel,#privacy-panel, #TOS-panel, #AATOS-panel, #freegallery-panel, #customgallery-panel, #couponcenter-panel, #appTutorial-panel").fadeOut(300);

                }
            });
            $("a#close-testimonials").click(function() {
                var zindex = $("#lightbox").css("z-index");
                $("#testimonials-panel").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                }
                else {
                    $("#lightbox").fadeOut(300);

                }


            });
            $("a#close-appTutorial").click(function() {
                var zindex = $("#lightbox").css("z-index");
                var video_div_val = document.getElementById('video_div').innerHTML;
                document.getElementById("changevideo").innerHTML = video_div_val;
                $("#appTutorial-panel").fadeOut(300);
                if (zindex == 10000)
                {
                    $("#lightbox").css({"z-index": "1000"});
                    document.getElementById("changevideo").innerHTML = video_div_val;
                }
                else {
                    $("#lightbox").fadeOut(300);
                    document.getElementById("changevideo").innerHTML = video_div_val;

                }


            });
            $("a.changeYoutube").click(function() {
                $("#youtube").attr("src", "https://www.youtube.com/embed/" + $(this)[0].title + "?rel=0")
            });
            $("a.schoolImg").click(function() {
                alert('test');
            });
            $("img#appStore").hover(
                    function() {
                        $(this).attr("src", "new_images/iosoff.png");
                    },
                    function() {
                        $(this).attr("src", "new_images/ioson.png");
                    });
            $("img#playStore").hover(
                    function() {
                        $(this).attr("src", "new_images/playStoreOn.png");
                    },
                    function() {
                        $(this).attr("src", "new_images/playStoreOff.png");
                    });

            $("img#applycode").hover(
                    function() {
                        $(this).attr("src", "new_images/applyPromoOn.jpg");
                    },
                    function() {
                        $(this).attr("src", "images/applyPromo.png");
                    });


            $("img#log_me").hover(
                    function() {
                        $(this).attr("src", "new_images/Log-me-out-create-later-on.png");
                    },
                    function() {
                        $(this).attr("src", "new_images/Log-me-out-create-later.png");
                    });

            $("img#create_coupan").hover(
                    function() {
                        $(this).attr("src", "new_images/Create-my-coupons-now-on.png");
                    },
                    function() {
                        $(this).attr("src", "new_images/Create-my-coupons-now.png");
                    });

            $("img#printButton").hover(
                    function() {
                        $(this).attr("src", "images/printOn.png");
                    },
                    function() {
                        $(this).attr("src", "images/printOff.png");
                    });
            $("img#redeemButton").hover(
                    function() {
                        $(this).attr("src", "images/redeemOn.png");
                    },
                    function() {
                        $(this).attr("src", "images/redeemOff.png");
                    });
            $("input#enterbutton").hover(
                    function() {
                        $(this).attr("src", "images/enterOn.png");
                    },
                    function() {
                        $(this).attr("src", "images/enter.png");
                    });

            $("input#loginbutton").hover(
                    function() {
                        $(this).attr("src", "images/loginOn.png");
                    },
                    function() {
                        $(this).attr("src", "images/loginOff.png");
                    });
            $("input#submitbutton").hover(
                    function() {
                        $(this).attr("src", "images/submitOn.png");
                    },
                    function() {
                        $(this).attr("src", "images/submit.png");
                    });
            $("img#clientsImage").hover(
                    function() {
                        $(this).attr("src", "<?php echo SITEURL ?>images/whatClientsAreSayingOn.png");
                    },
                    function() {
                        $(this).attr("src", "<?php echo SITEURL ?>images/whatClientsAreSaying.png");
                    });

        });

        function clientsSayings()
        {


            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#testimonials-panel").fadeIn(300);
        }


        function uvcouponsScreen()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#uvcouponsScreen-panel").css({"left": "50%"});
            $("#uvcouponsScreen-panel").css({"margin-left": "-350px"});
            $("#uvcouponsScreen-panel").css({"position": "fixed"});
            $("#uvcouponsScreen-panel").css({"display": "block"});
            $("#uvcouponsScreen-panel").css({"top": "100px"});
            $("#uvcouponsScreen-panel").css({"width": "700px"});
            $("#uvcouponsScreen-panel").css({"z-index": "10001"});
            $("#uvcouponsScreen-panel").fadeIn(300);
        }

        function couponCenter()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#couponcenter-panel").css({"left": "50%"});
            $("#couponcenter-panel").css({"position": "fixed"});
            $("#couponcenter-panel").css({"display": "block"});
            $("#couponcenter-panel").fadeIn(300);
        }
        function uploadecoupon()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#Example").css({"left": "50%"});
            $("#Example").css({"position": "fixed"});
            $("#Example").css({"display": "block"});
            $("#Example").fadeIn(300);
        }

        function createcoupon()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true) {
                $("#lightbox").css({"z-index": "10000"});
            } else {

            }
            $("#lightbox").fadeIn(0);
            $("#Example_create_coupon").css({"left": "50%"});
            $("#Example_create_coupon").css({"position": "fixed"});
            $("#Example_create_coupon").css({"display": "block"});
            $("#Example_create_coupon").fadeIn(300);
        }

        function uvcoupon()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#Example_uv_coupon").css({"left": "50%"});
            $("#Example_uv_coupon").css({"position": "fixed"});
            $("#Example_uv_coupon").css({"display": "block"});
            $("#Example_uv_coupon").fadeIn(300);
        }

        function customGallery()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#customgallery-panel").css({"left": "50%"});
            $("#customgallery-panel").css({"position": "fixed"});
            $("#customgallery-panel").css({"display": "block"});
            $("#customgallery-panel").fadeIn(300);
        }
        function freeGallery()
        {
            $("#lightbox").css({"height": $(document).height() + "px"});
            if ($('#lightbox').is(':visible') == true)
            {
                $("#lightbox").css({"z-index": "10000"});
            }
            else
            {

            }
            $("#lightbox").fadeIn(0);
            $("#freegallery-panel").css({"left": "50%"});
            $("#freegallery-panel").css({"position": "fixed"});
            $("#freegallery-panel").css({"display": "block"});
            $("#freegallery-panel").fadeIn(300);
        }
    </script>
<?php if ($code == 3) { ?>
        <script src="vendor/jquery.hashchange.min.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#all-tab").fadeIn(500);
                $(".allTab").css({"background": "url('images/allTabOn.png')"});
                $("a.all-tabb").click(function() {
                    $("#all-tab, #live-tab, #eat-tab, #play-tab").css({"display": "none"});
                    $(".allTab").css({"background": "url('images/allTabOn.png')"});
                    $(".liveTab").css({"background": "url('images/liveTab.png')"});
                    $(".eatTab").css({"background": "url('images/eatTab.png')"});
                    $(".playTab").css({"background": "url('images/playTab.png')"});
                    $("#all-tab").fadeIn(500);
                })
                $("a.live-tabb").click(function() {
                    $("#all-tab, #live-tab, #eat-tab, #play-tab").css({"display": "none"});
                    $(".liveTab").css({"background": "url('images/liveTabOn.png')"});
                    $(".allTab").css({"background": "url('images/allTab.png')"});
                    $(".eatTab").css({"background": "url('images/eatTab.png')"});
                    $(".playTab").css({"background": "url('images/playTab.png')"});

                    $("#live-tab").fadeIn(500);
                })
                $("a.eat-tabb").click(function() {
                    $("#all-tab, #live-tab, #eat-tab, #play-tab").css({"display": "none"});
                    $(".eatTab").css({"background": "url('images/eatTabOn.png')"});
                    $(".allTab").css({"background": "url('images/allTab.png')"});
                    $(".liveTab").css({"background": "url('images/liveTab.png')"});
                    $(".playTab").css({"background": "url('images/playTab.png')"});
                    $("#eat-tab").fadeIn(500);
                })
                $("a.play-tabb").click(function() {
                    $("#all-tab, #live-tab, #eat-tab, #play-tab").css({"display": "none"});
                    $(".playTab").css({"background": "url('images/playTabOn.png')"});
                    $(".allTab").css({"background": "url('images/allTab.png')"});
                    $(".liveTab").css({"background": "url('images/liveTab.png')"});
                    $(".eatTab").css({"background": "url('images/eatTab.png')"});
                    $("#play-tab").fadeIn(500);
                })
            })
        </script>
<? } else if ($code == 4) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $("div#clearbox").click(function() {
                    $("#socialMediaShare, #clearbox").fadeOut(300);
                })
                $("a#show-print").click(function() {
                    $("#lightbox, #print-panel").fadeIn(300);
                })
                $("a#show-email").click(function() {
                    $("#lightbox, #email-panel").fadeIn(300);
                })
                $("a#show-map").click(function() {
                    $("#lightbox, #map-panel").fadeIn(300);

                })
                $("a.show-mapit").click(function() {

                    document.getElementById('end').value = $(this).attr("title");
                    $("#map-panel").fadeOut(300);
                    $("#lightbox, #mapit-panel").fadeIn(300);
                    showMap();

                })

                $("a#close-mapit").click(function() {
                    $("#lightbox, #mapit-panel").fadeOut(300);
                })
                $("a#close-print").click(function() {
                    $("#lightbox, #print-panel").fadeOut(300);
                })
                $("a#close-email").click(function() {
                    $("#lightbox, #email-panel").fadeOut(300);
                })
                $("a#close-map").click(function() {
                    $("#lightbox, #map-panel").fadeOut(300);
                })
                $("a#show-social").click(function() {
                    $("#clearbox, #socialMediaShare").fadeIn(300);
                })
                $("a#close-print").click(function() {
                    $("#lightbox, #socialMediaShare").fadeOut(300);
                })
                $("div#lightbox").click(function() {
                    $("#lightbox, #print-panel, #socialMediaShare, #email-panel, #map-panel, #mapit-panel").fadeOut(300);
                })

                $("img#printButton").hover(
                        function() {
                            $(this).attr("src", "images/printOn.png");
                        },
                        function() {
                            $(this).attr("src", "images/printOff.png");
                        })

                $("img#emailButton").hover(
                        function() {
                            $(this).attr("src", "images/emailOn.png");
                        },
                        function() {
                            $(this).attr("src", "images/email.jpg");
                        })

                $("img#shareButton").hover(
                        function() {
                            $(this).attr("src", "images/shareOn.png");
                        },
                        function() {
                            $(this).attr("src", "images/share.jpg");
                        })
            })
        </script>
    <?
    if (!$sensor)
        $sensor = 'false';
    ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHS1kaDNtboj608VC5ok1OwZxmgCCSgtw&sensor=<?= $sensor ?>"></script>

        <script type="text/javascript">
            //<![CDATA[
            var map = null;
            var geocoder = null;

            function load() {
                var locations = [
    <?php
    foreach ($locations as $location) {
        ?>
                        ['<?= $location[locationName] ?>', '<?= $location[street] ?>, <?= $location[city] ?>, <?= $location[state] ?>'],
    <? } ?>
                ];

                geocoder = new google.maps.Geocoder();
                var bounds = new google.maps.LatLngBounds();
                var map = new google.maps.Map(document.getElementById('GMap'), {
                    zoom: 1,
                    center: new google.maps.LatLng(-33.92, 151.25),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow();
                var marker, i;

                for (i = 0; i < locations.length; i++) {
                    var name = locations[i][0];
                    geocoder.geocode({'address': locations[i][1]}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: name
                            });
                            bounds.extend(results[0].geometry.location);
                            map.fitBounds(bounds);
                        } else {

                        }
                    });
                }
            }

            function showMap() {

                if (document.getElementById("start").value != "") {
                    var start = document.getElementById("start").value;

                }
                else {
                    var start = "<?= $_SESSION[user_lat] ?>, <?= $_SESSION[user_long] ?>";

                }
                var end = document.getElementById("end").value;
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();

                var map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 7,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('total'));

                var request = {
                    origin: start,
                    destination: end,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };

                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(response);
                    }
                });
            }







            window.onload = function() {
                initialize();

            }//]]>



        </script>   

<? } else if ($code == 5) { ?>
        <script src="js/jquery.form.js" type="text/javascript"></script>

        <script type="text/javascript">
            function getSchools(a, b)
            {
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("listTheSchools").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "getschools.php?q=" + a + "&t=" + b, true);			// doesn't this need to be "../getschools.php"?? (since top.php - this file - is in includes, but getschools.php is in the parent directory (not includes)
                xmlhttp.send();


            }
            $(document).ready(function() {
                $("a#clickToUpload").click(function() {
                    $("#lightbox, #upload-panel").fadeIn(300);
                })

                $("a#clickToUpload1").click(function() {
                    $("#lightbox, #deepak").fadeIn(300);
                })

                $("a#close1").click(function() {
                    $("#lightbox, #deepak").fadeOut(300);
                })


                $("a#clickToUpload2").click(function() {
                    $("#lightbox, #deepak2").fadeIn(300);
                })

                $("a#close2").click(function() {
                    $("#lightbox, #deepak2").fadeOut(300);
                })


                $("a#clickToUpload3").click(function() {
                    $("#lightbox, #deepak3").fadeIn(300);
                })

                $("a#close3").click(function() {
                    $("#lightbox, #deepak3").fadeOut(300);
                })

                $("a#clickToUpload5").click(function() {
                    $("#lightbox, #deepak5").fadeIn(300);
                })

                $("a#close5").click(function() {
                    $("#lightbox, #deepak5").fadeOut(300);
                })


                $("a#close-upload").click(function() {
                    $("#lightbox, #upload-panel").fadeOut(300);
                })

                $("a#addLocations").click(function() {
                    $("#lightbox, #locations-panel").fadeIn(300);
                })
                $("a#close-locations").click(function() {
                    $("#lightbox, #locations-panel").fadeOut(300);
                })
                $("a#couponMessage").click(function() {
                    $("#lightbox, #coupon-message-panel").fadeIn(300);
                })
                $("a#close-coupon-message").click(function() {
                    $("#lightbox, #coupon-message-panel").fadeOut(300);
                })
                $("a#cancelSub").click(function() {
                    //console.log('a#cancelSubscription click');
                    $("#lightbox, #cancel-subscription-msg").fadeIn(300);
                })
                $("a#close-cancel-subscription").click(function() {
                    $("#lightbox, #cancel-subscription-msg").fadeOut(300);
                })
                $("a#couponTypeMessage").click(function() {
                    var editCid = $(this).data("cid");
                    $("#cidForEdit").val(editCid);
                    $("#lightbox, #coupon-type-panel").fadeIn(300);
                })
                $("a#close-type-panel").click(function() {
                    $("#lightbox, #coupon-type-panel").fadeOut(300);
                })
                $("a#addSchools").click(function() {
                    $("#lightbox, #school-panel").fadeIn(300);
                })
                $("a#close-school").click(function() {
                    $("#lightbox, #school-panel").fadeOut(300);
                })
                $("div#lightbox").click(function() {
                    console.log('lightbox div clicked');
                    $("#lightbox, #upload-panel, #locations-panel, #school-panel, #deepak, #deepak3, #coupon-type-panel, #cancel-subscription-msg, #coupon-message-panel, #uvcouponsScreen-panel").fadeOut(300);
                })
                $('#photoimg').live('change', function() {
                    $("#replaceImg").html('');
                    $("#uploadImage").html('<img src="images/lightbox-ico-loading.gif" alt="Uploading...."/>');
                    $("#imageform").ajaxForm({target: '#uploadImage'}).submit();
                    $("#lightbox, #upload-panel").fadeOut(300);
                    document.getElementById("imageURL").val = document.getElementById("imageURL").src;
                });


                $('#photoimg1').live('change', function() {
                    $("#replaceImg1").html('');
                    $("#uploadImage1").html('<img src="images/lightbox-ico-loading.gif" alt="Uploading...."/>');
                    $("#imageform1").ajaxForm({target: '#uploadImage1'}).submit();
                    $("#lightbox, #deepak").fadeOut(300);
                });


                $('#photoimg2').live('change', function() {
                    $("#replaceImg2").html('');
                    $("#uploadImage2").html('<img src="images/lightbox-ico-loading.gif" alt="Uploading...."/>');
                    $("#imageform2").ajaxForm({target: '#uploadImage2'}).submit();
                    $("#lightbox, #deepak2").fadeOut(300);
                });


                $('#photoimg3').live('change', function() {
                    $("#replaceImg3").html('');
                    $("#uploadImage3").html('<img src="images/lightbox-ico-loading.gif" alt="Uploading...."/>');
                    $("#imageform3").ajaxForm({target: '#uploadImage3'}).submit();
                    $("#lightbox, #deepak3").fadeOut(300);
                });


                $('#photoimg5').live('change', function() {
                    $("#replaceImg5").html('');
                    $("#uploadImage5").html('<img src="images/lightbox-ico-loading.gif" alt="Uploading...."/>');
                    $("#imageform5").ajaxForm({target: '#uploadImage5'}).submit();
                    $("#lightbox, #deepak5").fadeOut(300);
                });


                $('.deepak111').live('click', function() {

                    var vl = document.getElementById('cnt').value;
                    var err = 0;
                    var errr = 0;
                    for (k = 1; k <= vl; k++) {
                        if ($("#email" + k).length > 0) {
                            var locat = document.getElementById('location' + k).value;
                            var addres = document.getElementById('street' + k).value
                            var cit = document.getElementById('city' + k).value
                            var zi = document.getElementById('zip' + k).value
                            var ph = document.getElementById('phone' + k).value
                            if (locat == '') {
                                $('#location' + k).addClass('error_clr');
                                err++;
                            }
                            else
                                $('#location' + k).removeClass('error_clr');
                            if (addres == '') {
                                $('#street' + k).addClass('error_clr');
                                err++;
                            }
                            else
                                $('#street' + k).removeClass('error_clr');
                            if (cit == '') {
                                $('#city' + k).addClass('error_clr');
                                err++;
                            }
                            else
                                $('#city' + k).removeClass('error_clr');
                            if (zi == '') {
                                $('#zip' + k).addClass('error_clr');
                                err++;
                            }
                            else
                                $('#zip' + k).removeClass('error_clr');
                            if (ph == '') {
                                $('#phone' + k).addClass('error_clr');
                                err++;
                            }
                            else
                                $('#phone' + k).removeClass('error_clr');
                        }
                    }
                    if (err == 0) {
                        var compdiv = '';
                        var validat = '<input type="hidden" value="1"  name="select"/>'
                        for (i = 1; i <= vl; i++)
                        {
                            if ($("#email" + i).length > 0) {
                                var locat1 = document.getElementById('location' + i).value;
                                var addres1 = document.getElementById('street' + i).value;
                                var cit1 = document.getElementById('city' + i).value;
                                var zi1 = document.getElementById('zip' + i).value;
                                var ph1 = document.getElementById('phone' + i).value;
                                var state1 = document.getElementById('state' + i).value;
                                compdiv += '<div style="width:230px; float:left;padding: 10px;"><div><input type="hidden" name="state1[]" value=' + state1 + '></div><div><h3 style="margin:0px;">Address:&nbsp;&nbsp;&nbsp;' + addres1 + '</h3><input type="hidden" name="street[]" value=' + addres1 + '></div><div><h3 style="margin:0px;">City:&nbsp;&nbsp;&nbsp;' + cit1 + '</h3><input type="hidden" name="city[]" value=' + cit1 + '></div><div><h3 style="margin:0px;">State:&nbsp;&nbsp;&nbsp;' + state1 + '</h3></div><div><h3 style="margin:0px;">Zip:&nbsp;&nbsp;&nbsp;' + zi1 + '</h3><input type="hidden" name="zip[]" value=' + zi1 + '></div><div><h3 style="margin:0px;">Phone No:&nbsp;&nbsp;&nbsp;' + ph1 + '</h3><input type="hidden" name="phone[]" value=' + ph1 + '></div></div>';
                                //alert(locat1+"\n"+addres1+"\n"+cit1+"\n"+ph1);

                            }
                        }
                        document.getElementById('myAnchor').innerHTML = compdiv + validat;
                        $("#lightbox, #locations-panel").fadeOut(300);
                    }

                });
            });


        </script>
<? } ?>
<? if ($signUpPage == 1) { ?>
        <script type="text/javascript">
            function getSchools(a)
            {
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("listTheSchools").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "getschools.php?q=" + a, true);
                xmlhttp.send();


            }
        </script>

<? } ?>
    <style type="text/css">
        @-moz-document url-prefix() {
            #bottomLeftImage {
            top:2px !important;
        }
        #providingStudents {
            top:0px !important;
        }
        }
        .invalid_email_warning{
            color: red;
            font-weight: bold;
        }
        .invalid_email_succ{
            color:green;
            font-weight: bold;
        }
    </style>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <script>
        // GOOGLE ANALYTICS CODE HOOK
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34379160-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>
<body id="bodyimagefront"  onLoad="javascript:logointerval();">
    <script type="text/javascript">var isIeBeforeTen = false;</script>
    <!-- [if lt IE 10] >
        <script type="text/javascript">isIeBeforeTen = true;</script>
    <![endif]-->
    <script type="text/javascript">
        function alertIncompatibleBrowser() {
            alert("Your browser is not supported.  Please download Firefox, IE 10, or Chrome in order to use this website.");
        }
        if (isIeBeforeTen) {
            alertIncompatibleBrowser();
        } else {
            // double-check using jquery in case the conditional comment above failed
            if ($.browser.msie && parseInt($.browser.version, 10) < 10)
                alertIncompatibleBrowser();
        }

    </script>
    <div <?php
include_once('php_helpers/advertiserOrdersFunctionHelpers.php');

if ($front != 1 && $_GET['state'] == "") {
    echo 'id="top-nav-wrapper" style="position:relative;"';
} else {
    echo'id="top-nav-wrapper_front"';
}
?> >
        <div <?php
                        if ($front != 1 && $_GET['state'] == "") {
                            echo'style="height:89px; position:relative;"';
                        } else {
                            echo 'id="logo"';
                        }
                        ?>>
<? if (!$_SESSION[secret] || $_SESSION[secret] == md5('temp')) { ?>
                <a href="javascript: historyPushLoadStatesMap();">
<? } else if ($_SESSION[name] == ' ') {
    ?>
                    <a href="cart.php?ref=signup"><? } else { ?> <a href="account.php"> <?
                    }
                    if ($front == 1) {
                        ?>
                            <div style="background-image:url('animate/nogreen.png'); background-repeat:no-repeat; position:relative; top:21px; left:-9px; width: 246px;" id="anilogo"></div>
                            <div id="preload" style="display:none;"></div>
                            <!--<div style="background-image:url('new_images/UVlogowithglow.png'); background-repeat:no-repeat; position:relative; top:30px; left:1px; width: 224px;height: 95px;" id="anilogo">
                                    <img src="new_images/UVgifbanner.gif" />
                            </div>-->
                        <? } else { ?> <div <?php if ($_GET['state'] == "") { ?> style="left: 127px; position: absolute;top: 25px;width: 232px;" id="" <?php } else { ?> 
                                                                          style="position:relative; top:19px; left:-10px;" id="" <?php } ?>>
                                <img border="0" alt="University Values" src="new_images/University-Values-logo.png">

                            </div>
                            <div id="preload" style="display:none;"></div><? } ?>


                    </a>
                    </div>
                        <? if (($signUpPage != 1 && $_GET[ref] != 'signup' && !$sloganImg)) { ?>
                            <?php if ($show == 1) { ?>
                            <div style="position: absolute; left: 432px; top: 53px;">
                                <div class="mony_in_ur" style="float: left; font-size: 23px; margin-top: 8px;">Money in Your Pocket</div>
                                <div style="float: left; font-size: 12px; margin-top: 26px;">&reg;</div>
                            </div>
    <?php } else { ?>
                            <div id="slogan">
                            <?php
                            if ($orderdetailpage == 1 && (!advertiserHasOnlyOneCompletedOrder($_SESSION[pid])))
                                echo '<div style="position:absolute; left:43px; width:350px; top:-21px;"  ><span class="confrim">Advertiser Coupon Lounge</span>&#8482;</div>';
                            else
                                echo '<div class="mony_in_ur" style="float:left; margin-left:10px;" >Money in Your Pocket</div><div style="float: left; font-size: 12px; margin-top: 12px;">&reg;</div>';
                            ?>
                            </div>
                        <?php } ?>
                        <div style="<?php if ($show == 1) echo ''; ?>" id="top-buttons1">
                        <? if (!$_SESSION[secret] || ($_SESSION[secret] == md5('temp') && !$sloganImg) && !isset($orderdetailpage)) { ?>
                                <a style="padding-left: 10px; display:none;" href="javascript: void(0);" class="openAbout dropPage"><img src="new_images/aboutus-button.png" border=0 alt="About Us" /></a>
                                <a style="padding-left: 10px; display:none;" href="javascript: void(0);" class="openContact dropPage"><img src="new_images/contactus-button.png" border=0 alt="Contact Us" /></a>
                                <a style="padding-left: 10px; display:none;" href="javascript: void(0);" class="openAdvert dropPage"><img src="new_images/advertiser-section-button.png" border=0 alt="Advertising" /></a>
                        <? } else if (isset($_SESSION[secret]) && $_SESSION[secret] != md5('temp')) {
                            ?><br/>

                                <div style="margin-left: 165px;margin-top: -15px;"><a href="account.php?page=account" style="color:#000;font-weight: normal;">My Account</a> | <a href="index.php?logoff=1" style="color:#000;font-weight: normal;">Log Off</a></div>
                        <? } ?>
                        </div>

                        <? } else if ($sloganImg) { ?>

                                <?
                                if ($_GET[ref] != 'signup') { // if (advertiserHasCompletedAtLeastOneOrder($_SESSION[pid])) {//
                                    $margintop = 'margin-top:-10px;';
                                    ?>
                            <div style="position:absolute; top:11px; left:856px;"><a href="account.php?page=account" style="color:#000; font-weight: normal;">My Account</a> | <a href="index.php?logoff=1" style="color:#000;font-weight: normal;">Log Off</a></div>
        <?
    }
    if ($_GET[ref] == 'ccc') {
        $subheaderImg = $sloganImg;
        $sloganImg = 'cccHeader.png';
        $sloganMargin = 0;
    }
    ?>

                                        <?php if ($_GET[ref] == 'ccc' && $_GET[ch] != '1') {
                                            ?>
                            <div style=" left: 490px; position: absolute; top: 58px;">
                                <div style="font-size: 22px; float: left;" class="mony_in_ur"> </div>
    <?php } else if ($_GET[ref] == 'ccc' && $_GET[ch] == '1') { ?>
                                <div style=" left: 493px; position: absolute; top: 58px;">
                                    <div style="font-size: 22px; float: left;" class="mony_in_ur">Checkout </div>
                                <?php } else if ($_GET[ref] == 'signup' && $_GET[ch] != '1') { ?>
                                    <div style=" left: 493px; position: absolute; top: 58px;">
                                        <div style="font-size: 22px; float: left;" class="mony_in_ur">Your Cart</div>
                                <?php } else if ($_GET[ref] == 'signup' && $_GET[ch] == '1') { ?>
                                        <div style=" left: 493px; position: absolute; top: 58px;">
                                            <div style="font-size: 22px; float: left;" class="mony_in_ur">Checkout</div>
    <?php } else { ?>
                                            <div style=" left: 435px; position: absolute; top: 58px;">
                                                <div style="font-size: 22px; float: left;" class="mony_in_ur">Advertiser Coupon Lounge </div><div style="float: left"> &trade;</div>
                                        <?php } ?>
                            <!--<img src="images/<?= $sloganImg ?>" style="margin-left:<?= $sloganMargin ?>px; <?= $margintop ?>" />-->
                                        </div>
                                        <div id="filler" style="height:100px; width:30px;"></div>
                                    <? } ?>
                                </div>
                            </div>
<?php if ($front == 1 || $_GET['state'] != "") { ?>
                                <div style="position: fixed; right: 0px; cursor: pointer; top: 242px;" id="appTutorial" class="appTutorial">
                                    <span style="width:10px;"><img border="0" alt="advertising" src="new_images/how-to-use-your-coupons.png"></span>
                                </div>
<?php } ?>
                            <div id="<?php
if ($front != 1 && $_GET['state'] == "") {
    echo'body-background';
}
?>" <? if ($signUpPage == 1) echo "style=\"padding-top:20px;\""; else if ($sloganImg) echo "style=\"margin-top:30px;\""; ?> >

                                <div id="inner-body-control" style="position: relative;">

                                        <?
                                        if (($signUpPage != 1 && $_GET[ref] != 'signup' && !$sloganImg)) {
                                            if (($forget != 1) && ($show != 1)) {
                                                ?>
        <?php if ($orderdetailpage != 1) { ?>
                                                <div style="position:relative;">
                                                    <div style="position:absolute; left: 821px; top: -78px;">
                                                        <img src="new_images/socialicons.png" usemap="#socialiconurl" />
                                                        <map name="socialiconurl">
                                                            <area shape="rect" coords="10,10,30,55" target="_blank" alt="Facebook" href="http://facebook.com/universityvalues">
                                                            <area shape="circle" coords="63,30,20" target="_blank" href="http://twitter.com/univ_values" alt="Twitter">
                                                            <area shape="rect" coords="31,51,50,75" target="_blank" alt="Google" href="blog/">
                                                            <area shape="circle" coords="80,70,22" target="_blank" href="http://pinterest.com/univvalues" alt="PInterset">
                                                            <area shape="rect" coords="93,30,121,58" target="_blank" alt="Blogspot" href="https://plus.google.com/109692148817329523620/posts">
                                                            <area shape="circle" coords="142,64,20" target="_blank" href="http://youtube.com/universityvalues" alt="You Tube">
                                                        </map></div>
            <?php
        }
    }
}
?>
                                        <style>
                                            .error_clr{
                                                border: 1px solid #f30;
                                            }
                                        </style>