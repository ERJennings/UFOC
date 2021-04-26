<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Generator</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
<?php

/**
Entering an existing ElectionID along with an existing FacultyID into 
their relevant text boxes will cast a vote by inserting 
a record into the  voting table in the UFOC3 database. 

Entering an ElectionID into the
ElectionID textbox and hitting enter will generate the FacultyID of the winner of that 
particular election by returning the facultyID with the most votes. 

By: Jakob Brooks 4/26/2021
*/

echo "<html><body class = \"body\">

    
		<form Voting=\"Voting.php\" method=\"post\">
		Enter FacultyID: <input type=\"text\" name=\"faculty\">
		Enter ElectionID first: <input type=\"text\" name=\"election\">
		Enter Faculty Name to Vote: <input type=\"text\" name=\"name\">
		<br> <p>
		<input type=\"submit\" value=\"Submit\" name=\"submit\">
		<br><br>
		<input type=\"submit\" value=\"Back\" name=\"back\">
		<input type=\"submit\" value=\"Results\" name=\"results\">
		<br> <p></form>";
		
		$faculty = $_POST['faculty'];
		$vote = $_POST['name'];
		$election = $_POST['election'];

		$conn = mysqli_connect('localhost', 'root', 'root', 'ufoc3');
	if ($conn->connect_error) {die("Failed: " . $conn->connect_error);
	}
	
	if (isset($_POST['back'])) {
	header("Location: menu.php");
}
if (isset($_POST['submit'])) {
	
	$election = $_POST['election'];
		$lmao = (int)$election;
	//check if input for electionID is integer
	if ($lmao == 0) {
		echo "Enter an Integer that is not 0 for electionID";
		exit;
	}
	$sql = "select * from election where electionID = $election";
	$result = $conn-> query($sql);
	
	if ($result-> num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<br><b>Election ID: </b>". $row["ElectionID"]."<b> Results: </b>". $row["Results"]."<b> Nominees: </b>". $row["Nominates"]."<b> Committee: </b>". $row["Committee_CommitteeID"];
		}
	} else {
		echo"<br><br>No Election found";
	}
	
	
	$vote = $_POST['name'];
	$lmao = (int)$vote;
	//check if input is string- if it is not zero an integer was entered
	if ($lmao != 0) {
		echo "Enter an Name";
		exit;
	}
	//was using random integer out of 1000 for voteID but changed it to next after max so it is bug free
	$yeet = rand(1,1000);
	$sql3 = mysqli_query($conn, "SELECT MAX(VoteID) AS max FROM `votes`;");
	$res = mysqli_fetch_array($sql3);
	$nextID = $res['max'] + 1;
	
	$sql2 = "INSERT INTO `ufoc3`.`votes` (`VoteID`, `VotesDate`, `Election_ElectionID`, `FacID`) VALUES ('$nextID', '1111-11-11', '$election', '$faculty')";
	if(mysqli_query($conn, $sql2)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($conn);
}
}

if (isset($_POST['results'])) {
	$sql3 = "select FacID from votes where election_electionID = $election group by FacID order by count(*) desc limit 1";
	$result = $conn-> query($sql3);
	if ($result-> num_rows > 0) { 
		while($row = $result->fetch_assoc()) { 
			echo "<br><b>Faculty Id of Winner: </b>". $row["FacID"];
		}
	}
}

?>
</body>
</html>


