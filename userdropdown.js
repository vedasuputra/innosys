    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function profileFunction() {
      document.getElementById("profileDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.profilebtn')) {
        var dropdowns = document.getElementsByClassName("user-dropdown");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }

    $(".icon-search").on("click", function () {
      $(".search-form").fadeToggle();
    });

    $(".search-close").on("click", function () {
      $(".search-form").fadeToggle();
    });