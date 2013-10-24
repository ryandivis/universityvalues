var 

	mapWidth		= 400;

	mapHeight		= 276;



	shadowWidth		= 2;

	shadowOpacity		= 0.3;

	shadowColor		= "black";

	shadowX			= 1;

	shadowY			= 2;



	iPhoneLink		= true,



	isNewWindow		= false,



	borderColor		= "#ffffff",

	borderColorOver		= "#ffffff",



	nameColor		= "#000",

	nameFontSize		= "12px",

	nameFontWeight		= "bold",



	overDelay		= 300,



	map_data = {

    st1: {

   	 	id: 1,

		name: "Alabama",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('AL');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st2: {

    	id: 2,

		name: "Alaska",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('AK');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st3: {

		id: 3,

		name: "Arizona",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('AZ');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st4:{

    	id: 4,

		name: "Arkansas",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('AR');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st5:{

    	id: 5,

		name: "California",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('CA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st6:{

    	id: 6,

		name: "Colorado",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('CO');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st7:{

    	id: 7,

		name: "",

		shortname: "CT",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('CT');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st8:{

    	id: 8,

		name: "",

		shortname: "DE",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('DE');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st9:{

    	id: 9,

		name: "",

		shortname: "DC",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('DC');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st10:{

    	id: 10,

		name: "Florida",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('FL');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st11:{

    	id: 11,

		name: "Georgia",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('GA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st12:{

    	id: 12,

		name: "Hawaii",

		shortname: "HI",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('HI');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st13:{

    	id: 13,

		name: "Idaho",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('ID');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st14:{

    	id: 14,

		name: "Illinois",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('IL');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st15:{

    	id: 15,

		name: "Indiana",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('IN');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st16:{

    	id: 16,

		name: "Iowa",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('IA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st17:{

    	id: 17,

		name: "Kansas",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('KS');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st18:{

    	id: 18,

		name: "Kentucky",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('KY');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st19:{

    	id: 19,

		name: "Louisiana",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('LA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st20:{

    	id: 20,

		name: "Maine",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('ME');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st21:{

    	id: 21,

		name: "",

		shortname: "MD",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MD');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st22:{

    	id: 22,

		name: "",

		shortname: "MA",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st23:{

    	id: 23,

		name: "Michigan",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MI');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st24:{

    	id: 24,

		name: "Minnesota",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MN');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st25:{

    	id: 25,

		name: "Mississippi",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MS');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st26:{

    	id: 26,

		name: "Missouri",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MO');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st27:{

    	id: 27,

		name: "Montana",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('MT');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st28:{

    	id: 28,

		name: "Nebraska",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NE');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st29:{

    	id: 29,

		name: "Nevada",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NV');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st30:{

    	id: 30,

		name: "",

		shortname: "NH",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NH');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st31:{

    	id: 31,

		name: "",

		shortname: "NJ",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NJ');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st32:{

    	id: 32,

		name: "New Mexico",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NM');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st33:{

    	id: 33,

		name: "New York",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NY');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st34:{

    	id: 34,

		name: "North Carolina",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('NC');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st35:{

    	id: 35,

		name: "North Dakota",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('ND');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st36:{

    	id: 36,

		name: "Ohio",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('OH');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st37:{

    	id: 37,

		name: "Oklahoma",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('OK');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st38:{

    	id: 38,

		name: "Oregon",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('OR');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st39:{

    	id: 39,

		name: "Pennsylvania",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('PA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st40:{

    	id: 40,

		name: "",

		shortname: "RI",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('RI');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st41:{

    	id: 41,

		name: "South Carolina",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('SC');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st42:{

    	id: 42,

		name: "South Dakota",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('SD');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st43:{

    	id: 43,

		name: "Tennessee",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('TN');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st44:{

    	id: 44,

		name: "Texas",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('TX');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st45:{

    	id: 45,

		name: "Utah",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('UT');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st46:{

    	id: 46,

		name: "",

		shortname: "VT",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('VT');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st47:{

    	id: 47,

		name: "Virginia",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('VA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st48:{

    	id: 48,

		name: "Washington",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('WA');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st49:{

    	id: 49,

		name: "West Virginia",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('WV');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st50:{

    	id: 50,

		name: "Wisconsin",

		shortname: "",

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('WI');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st51:{

    	id: 51,

		name: "Wyoming",

		shortname: "" ,

		link: "javascript:historyPushLoadSchoolsForStateWithAbbrev('WY');",

		comment: "",

		image: "",

		color_map: "#8fc741", 

		color_map_over: "#aba9a0"

	},

    st52:{

    	id: 52,

		name: "",

		shortname: "" ,

		link: "javascript:window.open('",

		comment: "",

		image: "",

		color_map: "#e44d26", 

		color_map_over: "#f16529"

	}	

};