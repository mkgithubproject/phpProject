// $(document).ready(function () {
//   $(document).on("keypress", "#search-bar input", function (e) {
//     if (e.which == 13) {
//       var inputVal = $(this).val();
//       //alert("You've entered: " + inputVal);
//
//       history.pushState(null, null, "" + "project.php?s=" + inputVal);
//     searched_content(inputVal);
//     }
//   });
//    function searched_content(inputVal) {
//     $.ajax({
//       url: "" + location.pathname + "?s=" + inputVal,
//       method: "GET",
//       cache: false,
//       success: function (data) {
//         $("#container").html(data);
//       },
//     });
//   }
// });

function loadContent(inputVal, callback) {
  $.ajax({
    type: "GET",
    url: "" + inputVal,
    success: function (data) {
      var data1 = $(data).filter("#container").html();
      if (typeof data1 == "undefined") {
        data1 = $("#container > *", data);
      }
      $("#container").html(data1);
      if (callback && typeof callback == "function") {
        callback(data);
      }
    },
  });
}

$(document).on("keypress", "#search-bar input", function (evt) {
  if (evt.which == 13) {
    var inputVal = $(this).val();
    inputVal = location.pathname + "?s=" + inputVal;
    loadContent(inputVal, function (data) {
      history.pushState({ myTag: true }, null, "" + inputVal);
    });
  } else {
    return true;
  }
});


$(window).on("popstate", function (e) {
  if (e.originalEvent.state && e.originalEvent.state.myTag) {
    // to avoud safari popstate on page load
  
    var _href = location.href;
    
    loadContent(_href);
  }else{
    loadContent(location.href);
  }
  
  
});
