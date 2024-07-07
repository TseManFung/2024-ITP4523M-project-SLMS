$(document).ready(function () {
  $("#sort").on("change", function () {
    const sortValue = this.value;
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortValue);
    window.location.href = url.toString();
  });

  $("#search-box").on("click", function () {

    const searchInput = $("#search-input").val();
    const searchParam = "search";
    const currentUrl = new URL(window.location.href);

    if (searchInput === "") {
      if (currentUrl.searchParams.has(searchParam)) {
      currentUrl.searchParams.delete(searchParam);
      window.location.href = currentUrl.toString();
      }
    } else {
      currentUrl.searchParams.set(searchParam, searchInput);
      window.location.href = currentUrl.toString();
    }
  });
});
