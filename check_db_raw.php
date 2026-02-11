<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "proyek_1", 3307);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT events_id, title, image FROM events ORDER BY created_at DESC LIMIT 5";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["events_id"]. " - Title: " . $row["title"]. " - Image: " . $row["image"]. "\n";
    }
} else {
    echo "0 results";
}
$mysqli->close();
