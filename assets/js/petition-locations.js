const petitionLocations = (function ($) {
  const _petitionLocations = {};

  // Find placeholder elements in wp admin, petitions list
  const columnPlaceholders = Array.from(
    document.querySelectorAll(".petition-custom-column-placeholder")
  );
  let ids = [];
  if (columnPlaceholders.length) {
    ids = columnPlaceholders.map((ph) => ph.getAttribute("id"));
  }

  // Function that runs on init
  _petitionLocations.update_locations = function () {
    processIds(ids);
  };

  // Loop through ids and await resolved promise
  async function processIds(ids) {
    for (const id of ids) {
      try {
        const result = await getPetitionPublishLocation(id);
        if (result && result.data.message) console.log(result.data.message);
        if (result && result.data.message)
          document.getElementById(id).innerHTML = result.data.message;
      } catch (error) {
        console.log(error);
      }
    }
  }

  // Call on php function get_petition_publish_locations with ajax
  function getPetitionPublishLocation(id) {
    return new Promise(function (resolve, reject) {
      $.ajax({
        method: "POST",
        url: ajaxurl,
        dataType: "json",
        data: {
          action: "get_petition_publish_locations",
          id: id,
        },
        success: function (response) {
          if (response) {
            console.log(response.data.message);
            resolve(response);
          }
        },
        error: function (xhr) {
          console.log(xhr);
          reject(xhr);
        },
      });
    });
  }

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
