<html>
	<head>
		<meta charset="utf-8"/>
		<title>Dojave 112</title>
		<link rel="stylesheet" href="dojave_style.css">

		<script>
			function refresh(){
				location.reload();
			}
		
			function vise($record){
				window.open("dojavaVise.php?id=$record","_self");
				
			}
		</script
		
	</head>
	<body>
	
	<div id="wrapper">
		
		<h1>PRIMLJENE DOJAVE</h1>
		
		<button class="osvjezi" onClick="refresh()">OSVJEŽI</button>
		<?php
			
			require 'connection.php';
			
			global $connect;
			
			if(!$connect){
				echo "NEUSPJELO SPAJANJE NA BAZU PODATAKA";
			}else{
				ispis();	
			}
			
			
			function ispis(){
				
				global $connect;
				
				// define how many results you want per page
				$results_per_page = 10;
				
				// find out the number of results stored in database
				$sql='SELECT * FROM dojave';
				$result = mysqli_query($connect, $sql);
				$number_of_results = mysqli_num_rows($result);
				
				// determine number of total pages available
				$number_of_pages = ceil($number_of_results/$results_per_page);
				
				// determine which page number visitor is currently on
				if (!isset($_GET['page'])) {
				  $page = 1;
				} else {
				  $page = $_GET['page'];
				}
				
				// determine the sql LIMIT starting number for the results on the displaying page
				$this_page_first_result = ($page-1)*$results_per_page;
				
				// retrieve selected results from database and display them on page
				//$query = "SELECT * FROM dojave";
				$query = 'SELECT * FROM dojave ORDER BY vozila LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
				$sqli = mysqli_query($connect,$query);
				
				echo "
				<table border = 1>
					<tr>
						<th colspan='7' class='overhead'>Osobne informacije</th>
						<th colspan='4' class='overhead'>Informacije o nesreći</th>
					</tr>
					<tr>
						<th><a class='sort_link' href='prikazDojave.php'>Dojava primljena</a></th>
						<th>Ime</th>
						<th>Prezime</th>
						<th>Datum rođenja</th>
						<th>Krvna grupa</th>
						<th>Mobitel</th>
						<th>Mobitel ICE</th>
						<th><a class='sort_link' href='prikazDojaveVrstaNesrece.php'>Vrsta nesreće</a></th>
						<th><a class='sort_link' href='prikazDojavePodvrstaNesrece.php'>Podvrsta nesreće</a></th>
						<th><a class='sort_link' href='prikazDojaveOzlijedeni.php'>Ozlijeđeni</a></th>
						<th><a class='sort_link' href='prikazDojaveVozila.php'>Vozila</a></th>
						<th>Više informacija </th>
					</tr>";
					
					
					
					while($record = mysqli_fetch_array($sqli)){
					//for($i =$number_of_results; $i>0; $i--){
						echo "<tr>";
						echo "<td>" . $record['dojava_primljena'] . "</td>";
						echo "<td>" . $record['ime'] . "</td>";
						echo "<td>" . $record['prezime'] . "</td>";
						echo "<td>" . $record['dat_rod'] . "</td>";
						echo "<td>" . $record['krvna_grupa'] . "</td>";
						echo "<td>" . $record['mobitel'] . "</td>";
						echo "<td>" . $record['mobitel_ICE'] . "</td>";
						echo "<td>" . $record['vrsta_nesrece'] . "</td>";
						echo "<td>" . $record['podvrsta_nesrece'] . "</td>";
						echo "<td>" . $record['ozlijedeni'] . "</td>";
						echo "<td>" . $record['vozila'] . "</td>";
						echo "<td class='linkTable'><a class='linkVise' href=dojavaVise.php?id=".$record['ID'].">+</a></td>";					
						echo "</tr>";
					}
				
				echo "</table>";
				
				echo "<div id='stranice'>";
				// display the links to the pages
				for ($page=1;$page<=$number_of_pages;$page++) {
				  echo '<a class="broj_stranice" href="prikazDojaveVozila.php?page=' . $page . '">' . $page . '</a> ';
				}
				echo "</div>";
			}
		?>
		<!--<button class="osvjezi" onClick="refresh()">OSVJEŽI</button> -->
	</div>
	</body>

</html>

