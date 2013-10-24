// ------------------------------------------
		// Google Analytics Tracking Events functions
		// ------------------------------------------
        
        function trackViewSchoolList(){
        	_gaq.push(['_trackEvent', 'States', 'View School List', selectedState]);	
		}

		function trackViewCouponList(){
			_gaq.push(['_trackEvent', 'Schools', 'View Coupon List', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'View Coupon List', selectedState]);	
		}
        
        function trackViewCoupon(){
            // need to split this up - View from Website and View from Share Link 
        	if (userDidComeFromShareLink) {//  && selectedCouponID == sharedCouponID) {	
        		_gaq.push(['_trackEvent', 'Coupons', 'View from Share Link', selectedCouponBusinessPlusOfferString]);	
        	    _gaq.push(['_trackEvent', 'Schools', 'View Coupon from Share Link', selectedSchoolName]);	
        	    _gaq.push(['_trackEvent', 'States', 'View Coupon from Share Link', selectedState]);	
        	    userDidComeFromShareLink = false;
        	} else {
        		_gaq.push(['_trackEvent', 'Coupons', 'View from Website', selectedCouponBusinessPlusOfferString]);	
        	    _gaq.push(['_trackEvent', 'Schools', 'View Coupon from Website', selectedSchoolName]);	
        	    _gaq.push(['_trackEvent', 'States', 'View Coupon from Website', selectedState]);	
        	}
		}
        
        function trackRedeemCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Redeem', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Redeem Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Redeem Coupon', selectedState]);	
        }

        function trackPrintCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Print', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Print Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Print Coupon', selectedState]);	
        }

        function trackEmailCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Email', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Email Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Email Coupon', selectedState]);	
        }

        function trackShareCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Share', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Share Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Share Coupon', selectedState]);	
        }
        
        function trackLikeCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Like', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Like Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Like Coupon', selectedState]);	
        }

        function trackFollowCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Follow', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Follow Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Follow Coupon', selectedState]);	
        }

        function trackVisitWebsiteCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'Visit Website', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Visit Website Coupon', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Visit Website Coupon', selectedState]);	
        }

        function trackMoreLocationsCoupon(){
			_gaq.push(['_trackEvent', 'Coupons', 'More Locations', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'More Locations', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'More Locations', selectedState]);	
        }

        function trackMapItCouponView(){
			_gaq.push(['_trackEvent', 'Coupons', 'Map It - Coupon View', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Map It - Coupon View', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Map It - Coupon View', selectedState]);	
        }

        function trackMapItLocationsView(){
			_gaq.push(['_trackEvent', 'Coupons', 'Map It - Locations View', selectedCouponBusinessPlusOfferString]);	
			_gaq.push(['_trackEvent', 'Schools', 'Map It - Locations View', selectedSchoolName]);	
			_gaq.push(['_trackEvent', 'States', 'Map It - Locations View', selectedState]);	
        }

        function trackAppViewiOS(websiteType){
            // websiteType = 'standard' or 'mobile'
            if (websiteType == 'standard'){
				_gaq.push(['_trackEvent', 'Coupons', 'App View - iOS', selectedCouponBusinessPlusOfferString]);	
				_gaq.push(['_trackEvent', 'Schools', 'App View - iOS', selectedSchoolName]);	
				_gaq.push(['_trackEvent', 'States', 'App View - iOS', selectedState]);	
				_gaq.push(['_trackEvent', 'Full Site Landing Page', 'App View - iOS']);
            } else if (websiteType == 'mobile') {
				_gaq.push(['_trackEvent', 'Mobile Site Landing Page', 'App View - iOS']);
            }
        }

        function trackAppViewAndroid(websiteType){
        	// websiteType = 'standard' or 'mobile'
            if (websiteType == 'standard'){
				_gaq.push(['_trackEvent', 'Coupons', 'App View - Android', selectedCouponBusinessPlusOfferString]);	
				_gaq.push(['_trackEvent', 'Schools', 'App View - Android', selectedSchoolName]);	
				_gaq.push(['_trackEvent', 'States', 'App View - Android', selectedState]);	
				_gaq.push(['_trackEvent', 'Full Site Landing Page', 'App View - Android']);
            } else if (websiteType == 'mobile') {
            	_gaq.push(['_trackEvent', 'Mobile Site Landing Page', 'App View - Android']);
            }
        }

        function trackFeaturedIconClick(featuredCouponBusinessPlusOfferString){
            if (currentIpadContent == iPadContentPages.COUPON_DETAILS) {
            	_gaq.push(['_trackEvent', 'Coupons', 'Featured Icon Click', selectedCouponBusinessPlusOfferString + ": " + featuredCouponBusinessPlusOfferString]);	
            } else if (currentIpadContent == iPadContentPages.COUPON_LIST) {
            	_gaq.push(['_trackEvent', 'Schools', 'Featured Icon Click', selectedSchoolName + ": " + featuredCouponBusinessPlusOfferString]);
            }
        }

		// ------------------------------------------