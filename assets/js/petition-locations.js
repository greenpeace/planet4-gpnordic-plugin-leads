const petitionLocations = (function ($) {
  const _petitionLocations = {};
  let ids = [];

  // Find placeholder elements in wp admin, petitions list
  const columnPlaceholders = Array.from(
    document.querySelectorAll(".petition-custom-column-placeholder")
  );

  if (columnPlaceholders.length) {
    ids = columnPlaceholders.map((ph) => ph.dataset.petitionId);
  }

  // Function that runs on init
  _petitionLocations.update_locations = function () {
    processIds(ids);
  };

  // Loop through ids and await resolved promise
  async function processIds(ids) {
    for (const id of ids) {
      try {
        const { data } = await getPetitionPublishLocation(id);
        console.log("result", data);
        if (data.message) console.log(data.message);
        document.getElementById(`petition-${id}`).innerHTML = data.message;
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
          action: "get_or_set_petition_publish_locations",
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
