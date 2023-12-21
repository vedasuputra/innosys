<div id="statisticsCategory" class="tabcontent">
  <div class="section-head" style="margin-top: 2.5rem">
    <div>
      <h1 class="section-title">Statistics</h1>
    </div>
    <div class="navbar-end">
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">
          By category
        </button>
        <div id="myDropdown" class="dropdown-content">
          <a class="droplinks" onclick="openTab(event, 'statisticsCategory')" id="defaultOpen">By category</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
        </div>
      </div>
    </div>
  </div>

  <div class="statistics-container">
    <div class="statistics-left">
      <div class="statistics-text" onclick="javascript:location.href='#'">
        <h1>
          <?php echo $allCountTotal; ?>
        </h1>
        <span>Total Innovations</span>
      </div>
      <?php
      foreach ($categoryCounts as $categoryName => $count) {
        echo '<div class="statistics-text" onclick="javascript:location.href=\'#\'">';
        echo '<h1>' . $count . '</h1>';
        echo '<span>' . $categoryName . ' Innovations</span>';
        echo '</div>';
      }
      ?>
    </div>
    <div class="statistics-right">
      <canvas id="categoryChart"></canvas>
    </div>
  </div>
</div>

<div id="statisticsType" class="tabcontent">
  <div class="section-head" style="margin-top: 2.5rem">
    <div>
      <h1 class="section-title">Statistics</h1>
    </div>
    <div class="navbar-end">
      <div class="dropdown">
        <button onclick="myFunction2()" class="dropbtn">By type</button>
        <div id="myDropdown2" class="dropdown-content">
          <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
        </div>
      </div>
    </div>
  </div>
  <div class="statistics-container">
    <div class="statistics-left">
      <?php
      foreach ($typeCounts as $typeName => $count) {
        echo '<div class="statistics-text" onclick="javascript:location.href=\'innovation.php?id=\'">';
        echo '<h1>' . $count . '</h1>';
        echo '<span>' . $typeName . ' Innovations</span>';
        echo '</div>';
      }
      ?>
    </div>
    <div class="statistics-right">
      <canvas id="typeChart"></canvas>
    </div>
  </div>
</div>

<div id="statisticsConcentration" class="tabcontent">
  <div class="section-head" style="margin-top: 2.5rem">
    <div>
      <h1 class="section-title">Statistics</h1>
    </div>
    <div class="navbar-end">
      <div class="dropdown">
        <button onclick="myFunction3()" class="dropbtn">
          By concentration
        </button>
        <div id="myDropdown3" class="dropdown-content">
          <a class="droplinks" onclick="openTab(event, 'statisticsCategory')">By category</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsType')">By type</a>
          <a class="droplinks" onclick="openTab(event, 'statisticsConcentration')">By concentration</a>
        </div>
      </div>
    </div>
  </div>
  <div class="statistics-container">
    <div class="statistics-left">
      <?php
      foreach ($concentrationCounts as $concentrationName => $count) {
        echo '<div class="statistics-text" onclick="javascript:location.href=\'#\'">';
        echo '<h1>' . $count . '</h1>';
        echo '<span>' . $concentrationName . ' Innovations</span>';
        echo '</div>';
      }
      ?>
    </div>
    <div class="statistics-right">
      <canvas id="concentrationChart"></canvas>
    </div>
  </div>
</div>

<script type="text/javascript">
  const count_thesis = <?php echo json_encode($count_thesis); ?>;
  const count_internship = <?php echo json_encode($count_internship); ?>;
  const count_othercategory = <?php echo json_encode($count_othercategory); ?>;
  const categoryyear = <?php echo json_encode($categoryyear); ?>;

  Chart.defaults.font.family = "Inter";
  Chart.defaults.font.size = 15;
  Chart.defaults.color = "#041f35";
  Chart.defaults.font.weight = 500;
  Chart.defaults.plugins.tooltip.cornerRadius = 4;
  Chart.defaults.plugins.tooltip.padding = 12;
  Chart.defaults.plugins.tooltip.caretSize = 0;
  Chart.defaults.plugins.tooltip.usePointStyle = true;
  Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
  Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
  Chart.defaults.plugins.tooltip.mode = "index";
  Chart.defaults.plugins.tooltip.boxPadding = 2;
  Chart.defaults.plugins.tooltip.boxHeight = 11;
  Chart.defaults.plugins.tooltip.bodySpacing = 3;
  Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
  Chart.defaults.interaction.intersect = false;
  Chart.defaults.interaction.mode = "x";

  const categoryChartData = {
    labels: categoryyear,
    datasets: [{
        // [0]
        label: "Other Categories",
        backgroundColor: "#0c67ac",
        data: count_othercategory
      },
      {
        // [1]
        label: "Internship",
        backgroundColor: "#2d9cf1",
        data: count_internship
      },
      {
        // [2]
        label: "Thesis",
        backgroundColor: "#75bef6",
        data: count_thesis
      },
    ],
  }

  const categoryChartConfig = {
    type: "bar",
    data: categoryChartData,

    options: {
      animation: {
        duration: 0,
      },

      scales: {
        x: {
          stacked: true,
        },

        y: {
          stacked: true,
        },

        yAxes: [{
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],

        xAxes: [{
          ticks: {
            beginAtZero: true,
          },
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],
      },

      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: false,
        },

        tooltip: {
          itemSort: function(a, b) {
            return b.datasetIndex - a.datasetIndex;
          },
          callbacks: {
            footer: function(items) {
              return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
            },
          },
        },
      },
    },
  };

  const categoryChart = new Chart(
    document.getElementById('categoryChart').getContext("2d"),
    categoryChartConfig
  );
</script>

<script type="text/javascript">
  const count_website = <?php echo json_encode($count_website); ?>;
  const count_desktop = <?php echo json_encode($count_desktop); ?>;
  const count_mobile = <?php echo json_encode($count_mobile); ?>;
  const count_othertype = <?php echo json_encode($count_othertype); ?>;
  const typeyear = <?php echo json_encode($typeyear); ?>;

  Chart.defaults.font.family = "Inter";
  Chart.defaults.font.size = 15;
  Chart.defaults.color = "#041f35";
  Chart.defaults.font.weight = 500;
  Chart.defaults.plugins.tooltip.cornerRadius = 4;
  Chart.defaults.plugins.tooltip.padding = 12;
  Chart.defaults.plugins.tooltip.caretSize = 0;
  Chart.defaults.plugins.tooltip.usePointStyle = true;
  Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
  Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
  Chart.defaults.plugins.tooltip.mode = "index";
  Chart.defaults.plugins.tooltip.boxPadding = 2;
  Chart.defaults.plugins.tooltip.boxHeight = 11;
  Chart.defaults.plugins.tooltip.bodySpacing = 3;
  Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
  Chart.defaults.interaction.intersect = false;
  Chart.defaults.interaction.mode = "x";

  const typeChartData = {
    labels: typeyear,
    datasets: [{
        // [0]
        label: "Others",
        backgroundColor: "#0c67ac",
        data: count_othertype,
      },
      {
        // [1]
        label: "Mobile App",
        backgroundColor: "#2d9cf1",
        data: count_mobile,
      },
      {
        // [2]
        label: "Desktop App",
        backgroundColor: "#75bef6",
        data: count_desktop,
      },
      {
        // [3]
        label: "Website",
        backgroundColor: "#bde0fb",
        data: count_website,
      },
    ],
  }

  const typeChartConfig = {
    type: "bar",
    data: typeChartData,

    options: {
      animation: {
        duration: 0,
      },

      scales: {
        x: {
          stacked: true,
        },

        y: {
          stacked: true,
        },

        yAxes: [{
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],

        xAxes: [{
          ticks: {
            beginAtZero: true,
          },
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],
      },

      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: false,
        },

        tooltip: {
          itemSort: function(a, b) {
            return b.datasetIndex - a.datasetIndex;
          },
          callbacks: {
            footer: function(items) {
              return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
            },
          },
        },
      },
    },
  };

  const typeChart = new Chart(
    document.getElementById('typeChart').getContext("2d"),
    typeChartConfig
  );
</script>

<script type="text/javascript">
  const count_cyber = <?php echo json_encode($count_cyber); ?>;
  const count_msi = <?php echo json_encode($count_msi); ?>;
  const count_rib = <?php echo json_encode($count_rib); ?>;
  const count_otherconc = <?php echo json_encode($count_otherconc); ?>;
  const concyear = <?php echo json_encode($concyear); ?>;

  Chart.defaults.font.family = "Inter";
  Chart.defaults.font.size = 15;
  Chart.defaults.color = "#041f35";
  Chart.defaults.font.weight = 500;
  Chart.defaults.plugins.tooltip.cornerRadius = 4;
  Chart.defaults.plugins.tooltip.padding = 12;
  Chart.defaults.plugins.tooltip.caretSize = 0;
  Chart.defaults.plugins.tooltip.usePointStyle = true;
  Chart.defaults.plugins.tooltip.labelPointStyle = "circle";
  Chart.defaults.plugins.tooltip.backgroundColor = "#041f35";
  Chart.defaults.plugins.tooltip.mode = "index";
  Chart.defaults.plugins.tooltip.boxPadding = 2;
  Chart.defaults.plugins.tooltip.boxHeight = 11;
  Chart.defaults.plugins.tooltip.bodySpacing = 3;
  Chart.defaults.plugins.tooltip.multiKeyBackground = "rgb(0,0,0,0)";
  Chart.defaults.interaction.intersect = false;
  Chart.defaults.interaction.mode = "x";

  const concChartData = {
    labels: concyear,
    datasets: [{
        // [0]
        label: "Others",
        backgroundColor: "#0c67ac",
        data: count_otherconc,
      },
      {
        // [1]
        label: "Engineering and Business Intelligence",
        backgroundColor: "#2d9cf1",
        data: count_rib,
      },
      {
        // [2]
        label: "Management Information System",
        backgroundColor: "#75bef6",
        data: count_msi,
      },
      {
        // [3]
        label: "Cybersecurity",
        backgroundColor: "#bde0fb",
        data: count_cyber,
      },
    ],
  }

  const concChartConfig = {
    type: "bar",
    data: concChartData,

    options: {
      animation: {
        duration: 0,
      },

      scales: {
        x: {
          stacked: true,
        },

        y: {
          stacked: true,
        },

        yAxes: [{
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],

        xAxes: [{
          ticks: {
            beginAtZero: true,
          },
          gridLines: {
            display: true,
            color: "#e8eff6",
          },
          stacked: true,
        }, ],
      },

      maintainAspectRatio: false,

      plugins: {
        legend: {
          display: false,
        },

        tooltip: {
          itemSort: function(a, b) {
            return b.datasetIndex - a.datasetIndex;
          },
          callbacks: {
            footer: function(items) {
              return "Total: " + items.reduce((a, b) => a + b.parsed.y, 0);
            },
          },
        },
      },
    },
  };

  const concentrationChart = new Chart(
    document.getElementById('concentrationChart').getContext("2d"),
    concChartConfig
  );
</script>

<script>
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches(".dropbtn")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
</script>

<script>
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction2() {
    document.getElementById("myDropdown2").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches(".dropbtn")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
</script>

<script>
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction3() {
    document.getElementById("myDropdown3").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches(".dropbtn")) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
</script>

<script>
  function openTab(evt, tabName) {
    var j, tabcontent, droplinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (j = 0; j < tabcontent.length; j++) {
      tabcontent[j].style.display = "none";
    }
    droplinks = document.getElementsByClassName("tablinks");
    for (j = 0; j < droplinks.length; j++) {
      droplinks[j].className = droplinks[i].className.replace(
        " active",
        ""
      );
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>