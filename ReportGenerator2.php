<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Generator</title>
    <link rel="stylesheet" href="style.css">

</head>
<h1 class = h1>
    Generate Faculty Reports
</h1>
<?php


/**
		Enetering any integer into the text box will generate all of the data in all of the tables
		of the UFOC3 database except elections. 
		
		By: Jakob Brooks 4/26/2021
*/

echo "<html><body class = \"body\">

    
		<form ReportGenerator=\"ReportGenerator.php\" method=\"post\">
		<h3 class = \"h3\">Enter Desired Faculty ID:</h3>
		<input class = \"input\" type=\"text\" name=\"faculty\">
		<br> <p>
		<input class = \"input\" type=\"submit\" value=\"Submit\" name=\"submit\">
		<br><br>
		
		<br> <p></form>
		<div class=\"buttonrow\">
        <form class = \"menubutton\" action=\"adminmenu.php\">
            <button class = \"button\">Admin Menu</button>
        </form>
        <form class = \"menubutton\" action=\"ufocmenu.php\">
            <button class = \"button\">UFOC Menu</button>
        </form>
    </div>";
		
		$faculty = $_POST['faculty'];
		

$conn = mysqli_connect('localhost', 'root', 'root', 'ufoc3');
	if ($conn->connect_error) {die("Failed: " . $conn->connect_error);
	}
	
	/**********
function get_faculty (string $faculty) {
	

	$sql2 = "select * from faculty where FacName like \"%$faculty%\"";

	if ($result = mysqli_query($conn, $sql2)) { 
		while($row = $result->fetch_assoc()) {
			return "<br> name:". $row["FacName"]." ID:". $row["FacID"]." date hire:". $row["dateHire"]." tenure:". $row["tenure"];
			$result->close();
		}
	}
	else {
		return"Fail";
		$result->close();
	}
	echo"wtf";
	//$obj = $result->fetch_obj();
	//printf("Select returned %d rows.\n", $obj);
	
}*/
if (isset($_POST['back'])) {
	header("Location: menu.php");
}
if (isset($_POST['submit'])) {
	
	$faculty = $_POST['faculty'];
	//$committee = $_POST['committee'];
	//$election = $_POST['election'];
	//$meeting = $_POST['meeting'];
	
	$lmao = (int)$faculty;
	if ($lmao == 0) {
		echo "Enter an Integer that is not 0";
		exit;
	}

	//Faculty Information
	$sql = "select * from faculty";
	//Committees faculty belongs to
	$sql2 = "select * from committee";
	//meetings that committees that the faculty is part of have had
	$sql3 = "select * from meeting";
	//nominations given to faculty
	$sql4 = "select * from nominates";
	//votes cast by faculty
	$sql5 = "select * from votes";
	
	$result = $conn-> query($sql);
	$count2 = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count2 > 0) {
				echo "<br><b>Faculty ID: </b>". $row["FacID"]."<b> Faculty Name: </b>". $row["FacName"]."<b> Date Hired: </b>". $row["dateHire"]."<b> Tenure(#): </b>". $row["tenure"];
				continue;
			}
			echo "Faculty Information: <br><b>Faculty ID: </b>". $row["FacID"]."<b> Faculty Name: </b>". $row["FacName"]."<b> Date Hired: </b>". $row["dateHire"]."<b> Tenure(#): </b>". $row["tenure"];
			$count2 = $count2 + 1;
		}
	} else {
		echo"<br><br>No Faculty found";
	}
	
	$result = $conn-> query($sql2);
	$count3 = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count3 > 0) {
				echo "<b><br> ComID: </b>". $row["CommitteeID"]."<b> Name: </b>". $row["CommitteeName"]."<b> NumMembs: </b>". $row["numMembs"]."<b> Duty: </b>". $row["ComitDuty"];
				continue;
			}
			echo "<br><br>Committee Information: <b><br> ComID: </b>". $row["CommitteeID"]."<b> Name: </b>". $row["CommitteeName"]."<b> NumMembs: </b>". $row["numMembs"]."<b> Duty: </b>". $row["ComitDuty"];
			$count3 = $count3 + 1;
		}
	} else {
		echo"<br><br>No Committees found";
	}
	
	$result = $conn-> query($sql3);
	$count4 = 0;
	if ($result-> num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($count4 > 0) {
				echo "<b><br> MeetingID: </b>". $row["MeetingID"]."<b> Attendance: </b>". $row["Attendance"]."<b> Date: </b>". $row["MeetingDate"];
				continue;
			}
			echo "<br><br>Meeting Information: <b><br> MeetingID: </b>". $row["MeetingID"]."<b> Attendance: </b>". $row["Attendance"]."<b> Date: </b>". $row["MeetingDate"];
			$count4 = $count4 + 1;
		}
	} else {
		print'<br><br>No meetings found';
	}
	
	$result = $conn-> query($sql4);
	$count5 = 0;
	if ($result-> num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($count5 > 0) {
				echo "<b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
				continue;
			}
			echo "<br><br>Nominations: <b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
			$count5 = $count5 + 1;
		}
	} else {
		print'<br><br>No nominators found';
	}
	
	$result = $conn-> query($sql5);
	$count = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<br><b> VoteID: </b>". $row["VoteID"]."<b> Date: </b>". $row["VotesDate"]."<b> Election: </b>". $row["Election_ElectionID"]."<b> FacID: </b>". $row["FacID"];
				continue;
			}
			echo "<br><br>Votes Cast: <b><br> VoteID: </b>". $row["VoteID"]."<b> Date: </b>". $row["VotesDate"]."<b> Election: </b>". $row["Election_ElectionID"]."<b> FacID: </b>". $row["FacID"];
			$count = $count + 1; 
		}
	} else {
		echo"<br><br>No votes found";
	}

}
?>
</body>
</html>