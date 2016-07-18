var app = angular.module('app', []);

app.controller('MainCtrl', ["$scope", "$http", function($scope, $http) {
  
  $http.get('resources/academic_programs.json')
  .success(function(data, status, headers, config) {
    $scope.programs = data.academic_programs;
  })
  .error(function(data, status, headers, config) {
    console.log(status);
  });
  
  
  $http.get('resources/offices_services.json')
  .success(function(data, status, headers, config) {
    $scope.offices_services = data.offices;
  })
  .error(function(data, status, headers, config) {
    console.log(status);
  });
  
  $http.get('resources/buildings_3.json')
  .success(function(data, status, headers, config) {
    $scope.buildings_facilities = data.buildings;
  })
  .error(function(data, status, headers, config) {
    console.log(status);
  });
  
  
 $http.get('resources/column_4_data.json')
  .success(function(data, status, headers, config) {
    $scope.departments = data;
  })
  .error(function(data, status, headers, config) {
    console.log(status);
  });
  
  

}]);



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
          //adjustCol();
          console.log("Show");
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
            //adjustCol();
             console.log("hide");
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
  //e.preventDefault();
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
        //adjustCol();
      }
    )
    .dequeue()
    .clearQueue();
    
   
});



$("body").on("click", ".open a", function(e) {
  // e.preventDefault();
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
        
      }
    )
    .dequeue()
    .clearQueue();
});


//$(window).resize(adjustCol);

$(function() {
   //adjustCol();
});