$(document).ready(function () {
  $("#sort").on("change", function () {
    if (window.location.href.includes("sort=")) {
      window.location.href = window.location.href.replace(/([\?&]sort=)[^\&]+/, `$1${this.value}`);
    } else if(window.location.href.includes("?")) {
      window.location.href = `${window.location.href}&sort=${this.value}`;
    }else{
      window.location.href = `${window.location.href}?sort=${this.value}`;}
  });

  $("#search-box").on("click", function () {

    v = $("#search-input").val();
    if(v == ""){
      if (window.location.href.includes("search=")) {
        window.location.href = window.location.href.replace(/([\?&]search=)[^\&]+/, '');
      }

    }else{
      if (window.location.href.includes("search=")) {
        window.location.href = window.location.href.replace(/([\?&]search=)[^\&]+/, `$1${v}`);
      } else if(window.location.href.includes("?")) {
        window.location.href = `${window.location.href}&search=${v}`;
      }else{
        window.location.href = `${window.location.href}?search=${v}`;}
    }
  });
});
