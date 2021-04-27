<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Activity</title>
    <link rel="stylesheet" href="style.css">

</head>

<h1 class = h1>
    My Committee Activity
</h1>
<?php


/**
		Report Generator for UFOC3 database in MYSQL. Entering the FacultyID into the 
		text box and hitting enter will return all the relevant information in the database
		for that particular Faculty Member. 
		
		This includes the facultyID, the commiittees the faculty is
		a part of, the meetings the committees have had that the faculty is a part of, all nomination information,
		votes cast by the faculty, and elections that committees have had that the faculty has been a part of.
		
		By: Jakob Brooks 4/26/2021
*/

echo "<html><body class = \"body\">

    
		<form ReportGenerator=\"ReportGenerator.php\" method=\"post\">
		<h3 class = \"h3\">Enter Your Faculty ID:</h3>
		<input class = \"input\" type=\"text\" name=\"faculty\">
		<br> <p>
		<input class = \"input\" type=\"submit\" value=\"Submit\" name=\"submit\">
		<br><br>
	
		<br> <p></form>
		
		<div class=\"buttonrow\">
        <form class = \"menubutton\" action=\"menu.php\">
            <button class = \"button\">Main Menu</button>
        </form>
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
	$sql = "select * from faculty where FacID like \"%$faculty%\"";
	//Committees faculty belongs to
	$sql2 = "select * from committee where CommitteeID in (select b.ComID from belongsto b where b.FacID like \"%$faculty%\")";
	//meetings that committees that the faculty is part of have had
	$sql3 = "select * from meeting where Committee_CommitteeID in (select CommitteeID from committee where CommitteeID in (select b.ComID from belongsto b where b.FacID like \"%$faculty%\"))";
	//nominations given to faculty
	$sql4 = "select * from nominates where FacID like \"%$faculty%\"";
	//nominations given from faculty
	$sql5 = "select * from nominates where NominatorFacID like \"%$faculty%\"";
	//votes cast by faculty
	$sql6 = "select * from votes where FacID like \"%$faculty%\"";
	//elections committees that faculty member is a part of has had
	$sql7 = "select * from election where Committee_CommitteeID in (select CommitteeID from committee where CommitteeID in (select b.ComID from belongsto b where b.FacID like \"%$faculty%\"))";
	
	$result = $conn-> query($sql);
	$count = 0;
	if ($result-> num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<br><b>Faculty ID: </b>". $row["FacID"]."<b> Faculty Name: </b>". $row["FacName"]."<b> Date Hired: </b>". $row["dateHire"]."<b> Tenure(#): </b>". $row["tenure"];
				continue;
			}
			echo "Faculty Information: <br><b>Faculty ID: </b>". $row["FacID"]."<b> Faculty Name: </b>". $row["FacName"]."<b> Date Hired: </b>". $row["dateHire"]."<b> Tenure(#): </b>". $row["tenure"];
			$count = $count + 1;
		}		
	} else {
		echo"<br><br>No Faculty found";
	}
	
	$result = $conn-> query($sql2);
	$count = 0;
	if ($result-> num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<b><br> ComID: </b>". $row["CommitteeID"]."<b> Name: </b>". $row["CommitteeName"]."<b> NumMembs: </b>". $row["numMembs"]."<b> Duty: </b>". $row["ComitDuty"];
				continue;
			}
			echo "<br><br>Committee Information: <b><br> ComID: </b>". $row["CommitteeID"]."<b> Name: </b>". $row["CommitteeName"]."<b> NumMembs: </b>". $row["numMembs"]."<b> Duty: </b>". $row["ComitDuty"];
			$count = $count + 1;
		}
	} else {
		echo"<br><br>No Committees found";
	}
	
	$result = $conn-> query($sql3);
	$count = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<b><br> MeetingID: </b>". $row["MeetingID"]."<b> Attendance: </b>". $row["Attendance"]."<b> Date: </b>". $row["MeetingDate"];
				continue;
			}
			echo "<br><br>Meeting Information: <b><br> MeetingID: </b>". $row["MeetingID"]."<b> Attendance: </b>". $row["Attendance"]."<b> Date: </b>". $row["MeetingDate"];
			$count = $count + 1;
		}
	} else {
		print'<br><br>No meetings found';
	}
	
	$result = $conn-> query($sql4);
	$count = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
				continue;
			}
			echo "<br><br>Positions You've been Nominated for: <b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
			$count = $count + 1;
		}
	} else {
		print'<br><br>No nominators found';
	}
	
	$result = $conn-> query($sql5);
	$count = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
				continue;
			}
			echo "<br><br>Faculty you have nominated: <b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
			$count = $count + 1;
		}
	} else {
		print'<br><br>No Nominees found';
	}
	
	$result = $conn-> query($sql6);
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
	
	$result = $conn-> query($sql7);
	$count = 0;
	if ($result-> num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			if ($count > 0) {
				echo "<b><br> ElectionID: </b>". $row["ElectionID"]."<b> Results: </b>". $row["Results"]."<b> Nominates: </b>". $row["Nominates"]."<b> CommitteeID: </b>". $row["Committee_CommitteeID"];
				continue;
			}
			echo "<br><br>Elections: <b><br> ElectionID: </b>". $row["ElectionID"]."<b> Results: </b>". $row["Results"]."<b> Nominates: </b>". $row["Nominates"]."<b> CommitteeID: </b>". $row["Committee_CommitteeID"];
			$count = $count + 1;
		}
	} else {
		echo"<br><br>No elections found";
	}

}
?>
</body>
</html>