<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Generator</title>
    <link rel="stylesheet" href="style.css">

</head>
<?php


/**
Enter Committee Name: <input type=\"text\" name=\"committee\">
Enter ElectionID: <input type=\"text\" name=\"election\">
Enter Meeting Date(yyyy-mm-dd): <input type=\"text\" name=\"meeting\">
 */

echo "<html><body class = \"body\">
    
		<form ReportGenerator=\"ReportGenerator.php\" method=\"post\">
		Enter Faculty ID: <input type=\"text\" name=\"faculty\">
		<br> <p>
		<input type=\"submit\" value=\"Submit\" name=\"submit\">
		<br><br>
		<input type=\"submit\" value=\"Back\" name=\"back\">
		<br> <p></form>";

$faculty = $_POST['faculty'];


$conn = mysqli_connect('localhost', 'root', 'root', 'ufoc');
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

    $result = $conn-> query($sql);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "Faculty Information: <br><b>Faculty ID: </b>". $row["FacID"]."<b> Faculty Name: </b>". $row["FacName"]."<b> Date Hired: </b>". $row["dateHire"]."<b> Tenure(#): </b>". $row["tenure"];
        }
    } else {
        echo"<br><br>No Faculty found";
    }

    $result = $conn-> query($sql2);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br><br>Committee Information: <b><br> ComID: </b>". $row["CommitteeID"]."<b> Name: </b>". $row["CommitteeName"]."<b> NumMembs: </b>". $row["numMembs"]."<b> Duty: </b>". $row["ComitDuty"];
        }
    } else {
        echo"<br><br>No Committees found";
    }

    $result = $conn-> query($sql3);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br><br>Meeting Information: <b><br> MeetingID: </b>". $row["MeetingID"]."<b> Attendance: </b>". $row["Attendance"]."<b> Date: </b>". $row["MeetingDate"];
        }
    } else {
        print'<br><br>No meetings found';
    }

    $result = $conn-> query($sql4);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br><br>Positions You've been Nominated for: <b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
        }
    } else {
        print'<br><br>No nominators found';
    }

    $result = $conn-> query($sql5);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br><br>Faculty you have nominated: <b><br> NomID: </b>". $row["NomID"]."<b> NomDate: </b>". $row["NomDate"]."<b> NomSeat: </b>". $row["NomSeat"]."<b> FacID: </b>". $row["FacID"]."<b> NominatorFacID: </b>". $row["NominatorFacID"];
        }
    } else {
        print'<br><br>No Nominees found';
    }

    $result = $conn-> query($sql6);
    if ($result-> num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br><br>Votes Cast: <b><br> VoteID: </b>". $row["VoteID"]."<b> Date: </b>". $row["VotesDate"]."<b> Election: </b>". $row["Election_ElectionID"]."<b> FacID: </b>". $row["FacID"];
        }
    } else {
        echo"<br><br>No votes found";
    }

}
?>
</body>
</html>