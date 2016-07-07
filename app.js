var app = angular.module('app', []);

app.controller('MainCtrl', ['$scope',
  function($scope) {
    $scope.data = {
      selected_dept: "SELECT A DEPARTMENT"
    }
    // 3 arrays of objects
    $scope.departments_programs = [{
        main_dir_section: "Departments and Programs",
        dept_name: "Art Gallery",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "99",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      },

      {
        main_dir_section: "Departments and Programs",
        dept_name: "Box Office",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "65",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      },

      {
        main_dir_section: "Departments and Programs",
        dept_name: "Campus Safety",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "23",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      }
    ]; // Departments & Programs Array

    $scope.offices_services = [{
        main_dir_section: "Offices & Services",
        dept_name: "Athletics",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "71",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      },

      {
        main_dir_section: "Offices & Services",
        dept_name: "Administration",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "91",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      },

      {
        main_dir_section: "Offices & Services",
        dept_name: "Student Recreational Services",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "76",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      },

      {
        main_dir_section: "Offices & Services",
        dept_name: "Student Health Services",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "55",
        phone: "909.274.4630",
        fax: "909.274.2998",
        text: ''
      }
    ]; // Offices & Services Array

    $scope.buildings_facilities = [{
        main_dir_section: "Building & Facilities",
        dept_name: "Math & Science",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "45",
        phone: "909.274.4630",
        fax: "909.274.2998",
        map_pix_url: "http://codeovermatter.com/hope-edu/images/maps/map1.jpg",
        map_url: "http://myatlascms.com/map/?id=811&mrkIid=134068",
        text: ''
      },

      {
        main_dir_section: "Building & Facilities",
        dept_name: "Language Center",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "13",
        phone: "909.274.4630",
        fax: "909.274.2998",
        map_pix_url: "http://codeovermatter.com/hope-edu/images/maps/map2.jpg",
        map_url: "http://myatlascms.com/map/?id=811&mrkIid=134069",
        text: ''
      },

      {
        main_dir_section: "Building & Facilities",
        dept_name: "Business Administration",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "66",
        phone: "909.274.4630",
        fax: "909.274.2998",
        map_pix_url: "http://codeovermatter.com/hope-edu/images/maps/map3.jpg",
        map_url: "http://myatlascms.com/map/?id=811&mrkIid=134073",
        text: ''
      },

      {
        main_dir_section: "Building & Facilities",
        dept_name: "Child Care Center",
        address: "1100 N. Grand Ave",
        city: "Walnut",
        state: "CA",
        zip: "91789",
        building: "10",
        phone: "909.274.4630",
        fax: "909.274.2998",
        map_pix_url: "http://codeovermatter.com/hope-edu/images/maps/map4.jpg",
        map_url: "http://myatlascms.com/map/?id=811&mrkIid=134096",
        text: ''
      }
    ]; // Building & Facilities Array
  
    $scope.department_list = [{
    "id" : 0,
		"dept_name": "Information Technology",
		"people": [{
			"fname": "Vick",
			"lname": "Eap"
		}, {
			"fname": "Matthew",
			"lname": "Spellman"
		}, {
			"fname": "Betty",
			"lname": "Lin"
		}]
	},

	{
    "id" : 1,
		"dept_name": "Alumni and Family Engagement",
		"people": [{
			"fname": "Joe",
			"lname": "Shmoe"
		}, {
			"fname": "Mary",
			"lname": "Jane"
		}, {
			"fname": "Sam",
			"lname": "Lam"
		}]
	}, {
    "id" : 2,
		"dept_name": "Art",
		"people": [
      {"fname": "Edmund",
			"lname": "Chase"}
    ]
	}, {
    "id" : 3,
		"dept_name": "Asian Studies",
		"people": [{}]
	}
]
  }]) /* End of Angular Code */

function adjustCol() {
  var windowH = $(document).innerHeight();
  $('.col').height(windowH);
}

function showSubLists() { 
  var divs = $('.sectionContainer'),
      len = divs.length;
  // iterate over each container and show
  for (var i = 0; i < len; i++) {
      var div = divs[i];
    $(div).removeClass('closed').addClass('open').find('.hiddenSub').css('display', 'block')
      .animate({
          "margin-left": 10,
          "opacity": 1,
          "padding-left": 10
        },
        275,
        function() {
          adjustCol();
        }
      )
    }
}

// phpmyadmin-ctl install

function hideSubLists() {
    var divs = $('.sectionContainer'),
        len = divs.length;
    for (var i = 0; i < len; i++) {
      var div = divs[i];
      $(div).removeClass('open').addClass('closed').find('.hiddenSub')
        .animate({
            "margin-left": 0,
            "opacity": 0,
            "padding-left": 0
          },
          100,
          function() {
            adjustCol();
          }
        ).css('display', 'none')
    }
}



// Event Listener for Search keyup, show sublist of dep
$('#search_field').on('keyup', function(e) {
  var self = $(this),
      input_length = self.val().length;

  if (input_length > 2) {
      showSubLists();
  } else {
      hideSubLists();
  }
});

$("body").on("click", ".closed a", function(e) {
  e.preventDefault();
  $(this)
    .parent()
    .parent()
    .removeClass("closed")
    .addClass("open")
    .find(".hiddenSub")
    .css("display", "block")
    .animate({
        "margin-left": 10,
        "opacity": 1,
        "padding-left": 10
      },
      275,
      function() {
        //alert( "done opening" );
        adjustCol();
      }
    )
    .dequeue()
    .clearQueue();
});

$("body").on("click", ".open a", function(e) {
  e.preventDefault();
  $(this)
    .parent()
    .parent()
    .removeClass("open")
    .addClass("closed")
    .find(".hiddenSub")
    .animate({
        "margin": 0,
        "opacity": 0,
        "padding-left": 0
      },
      100,
      function() {
        $(this).css("display", "none");
        adjustCol();
      }
    )
    .dequeue()
    .clearQueue();
});


$(window).resize(adjustCol);

$(function() {
  adjustCol();
});