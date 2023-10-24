<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports - Scrap Management App</title>
  <link rel="stylesheet" href="stats.css">
</head>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li style="background-color:black"><a href="stats.php">Stats</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="message.php">Messages</a></li>
        <li><a href="settings.php">Settings</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container">

      <div style="text-align: center;">
        <h2>Total quantity of the scraps</h2>
      </div>
      <div class="chart-container" id="chartContainer">
        <!-- Chart will be dynamically added here -->
        <h4 id="total" style="color:red"></h4></h4>
      </div>
      
    </div>
  </main>
  <?php
  session_start();

  if (!isset($_SESSION['admin_id'])) {
    // Redirect to sign-in page if not logged in
    header("Location: ../signin.php");
    exit();
  }
  require "../dbconnector.php";

  $sql = "SELECT scrapname, SUM(quantity) as total_quantity
  FROM orders
  WHERE status = 'accepted'
  GROUP BY scrapname ORDER By total_quantity desc;";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $total_quantity[] = $row['total_quantity'];
    $scrapname[] = $row['scrapname'];
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
  <script>


    document.addEventListener('DOMContentLoaded', function () {
      // PHP array to JSON
      const jsonData = <?php echo json_encode($total_quantity, JSON_NUMERIC_CHECK); ?>;
      const scrapname = <?php echo json_encode($scrapname); ?>;
      let total_quantity = new Array();
      let otherData = 0;
      let name = new Array();
      if (jsonData.length > 5) {
        for (let i = 0; i < 5; i++) {
          total_quantity[i] = jsonData[i];
          name[i] = scrapname[i];
        }
        for (let i = 5; i < jsonData.length; i++) {
          otherData += jsonData[i];
        }
        total_quantity[5] = otherData;
        name[5] = "Others";

      }
      else {
        name = [...scrapname];
        total_quantity = [...jsonData];
        console.log(scrapname.length)
      }
      // ApexCharts options
      const options = {
        series: [...total_quantity],
        chart: {
          type: 'pie',
          width: '100%', // Adjust the width as needed
          height: '400px',
        },
        labels: [...name],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: '100%',
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      };
      var sum = jsonData.reduce(function(a, b){
        return a + b;
    }, 0);
      document.getElementById("total").innerHTML="Total quantity : "+sum;
      // Create the chart
      const chart = new ApexCharts(document.getElementById('chartContainer'), options);
      chart.render();


    });
  </script>
  ?></h5>
</body>

</html>