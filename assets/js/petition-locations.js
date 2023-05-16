const petitionLocations = (function ($) {
  console.log("petitionLocations");
  const _petitionLocations = {};
  // let admin_ajax_url = gplp_leads_ajax.ajaxurl;

  _petitionLocations.update_locations = function () {
    $.ajax({
      method: "POST",
      url: ajaxurl,
      dataType: "json",
      data: {
        action: "get_petition_publish_locations",
      },
      success: function (response) {
        if (response) console.log(response.data.message);
      },
      error: function (xhr) {
        console.log(xhr);
        // console.log(xhr.responseJSON.data.message);
      },
    });
  };
  http: return {
    init: function () {
      if (true) {
        _petitionLocations.update_locations();
      }
    },
  };
})(jQuery);

jQuery(function ($) {
  petitionLocations.init();
});
