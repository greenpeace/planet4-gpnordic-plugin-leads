const petitionLocations = (function ($) {
  console.log("petitionLocations");
  const _petitionLocations = {
    // $trigger_notifications_button: null,
  };
  let admin_ajax_url = gplp_leads_ajax.ajaxurl;
  console.log(admin_ajax_url);

  _petitionLocations.update_locations = function ($button) {
    // $button.addClass("triggering-notifications");
    $.ajax({
      method: "POST",
      url: admin_ajax_url,
      dataType: "json",
      data: {
        action: "get_petition_publish_locations",
      },
    });
  };
  return {
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
