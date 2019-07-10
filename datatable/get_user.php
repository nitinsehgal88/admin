<?php 
$servername = "localhost";
$username = "root";
$password = "welcome@123";
$dbname = "testing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["email"]. "<br>";
        $data['name'] = $row["name"];
        $data['email'] = $row["email"];
        $data['phone'] = $row["phone"];
        $final_arr[] = $data;
    }
} else {
    echo "0 results";
}
$conn->close();
// print_r($final_arr);

$response = array (
    'iTotalRecords' => $result->num_rows,
    'iTotalDisplayRecords' => 5,
    'sEcho' => 5,
    'aaData' => $final_arr,
);
// echo "<pre>";
// print_r(json_encode($response));

echo json_encode($response);
?>  