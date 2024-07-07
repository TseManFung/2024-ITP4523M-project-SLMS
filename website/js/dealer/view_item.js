$(document).ready(function () {
  $("#sort").on("change", function () {
    const sortValue = this.value;
    const url = new URL(window.location.href);
    url.searchParams.set("sort", sortValue);
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

function Submitfilter() {
  // get name="Category"
  Checkboxes = document.getElementsByName("Category");
  const currentUrl = new URL(window.location.href);
  for (const ele of Checkboxes) {
    if (ele.checked) {
      currentUrl.searchParams.delete(ele.value);
    } else {
      currentUrl.searchParams.set(ele.value, ele.value);
    }
  }
  // get  id="minPrice" id="maxPrice"
  if ($("#minPrice").val()) {
    currentUrl.searchParams.set("minPrice", $("#minPrice").val());
  } else {
    currentUrl.searchParams.delete("minPrice");
  }
  if ($("#maxPrice").val()) {
    currentUrl.searchParams.set("maxPrice", $("#maxPrice").val());
  } else {
    currentUrl.searchParams.delete("maxPrice");
  }

  window.location.href = currentUrl.toString();
}
