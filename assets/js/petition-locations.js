jQuery(function ($) {
  Array.from(
    document.querySelectorAll(".petition-custom-column-placeholder")
  ).forEach((el) => {
    new Vue({
      el: el,
      data: {
        id: el.dataset.petitionId,
        loading: true,
        pages: [],
      },
      mounted() {
        // Use jQuery to fetch the data from the server
        $.ajax({
          url: `/${window.location.pathname.split('/')[1]}/wp-json/gplp/v2/petition_locations/${this.id}`,
          method: "GET",
          beforeSend: (xhr) => {
            xhr.setRequestHeader("X-WP-Nonce", gplp.nonce);
          },
          success: (data) => {
            this.pages = data.map((page) => {
              page.url = page.url.replace(/&amp;/g, "&");
              return page;
            });
            this.loading = false;
          },
        });
      },
      methods: {
        getColorByStatus(status) {
          if (status === "draft") return "orange";
          if (status === "publish") return "green";
          return "black";
        },
      },
    });
  });
});
