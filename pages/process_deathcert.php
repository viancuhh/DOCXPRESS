<?php
// Database connection details
$host = "localhost";  // MySQL host
$dbname = "docxpress"; // database name
$user = "root";        // username
$password = "";        // password

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $lastName = $_POST['lastName'] ?? '';
    $firstName = $_POST['firstName'] ?? '';
    $middleName = $_POST['middleName'] ?? '';
    $suffix = $_POST['suffix'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $birthday = $_POST['birthday'] ?? null;
    $deathDate = $_POST['deathDate'] ?? null;
    $deathPlace = $_POST['deathPlace'] ?? '';
    $reqRelationship = $_POST['reqRelationship'] ?? '';
    $reqLastName = $_POST['reqLastName'] ?? '';
    $reqFirstName = $_POST['reqFirstName'] ?? '';
    $reqMiddleName = $_POST['reqMiddleName'] ?? '';
    $copies = isset($_POST['copies']) ? (int)$_POST['copies'] : 1;
    $reqPurpose = $_POST['reqPurpose'] ?? '';

    // Prepare and bind for dcertholders table
    $stmt1 = $conn->prepare("INSERT INTO dcertholders (
        last_name, first_name, middle_name, suffix, sex, birthday, 
        death_date, death_place
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt1->bind_param("ssssssss", $lastName, $firstName, $middleName, $suffix, $sex, $birthday, $deathDate, $deathPlace);

    if ($stmt1->execute()) {
        echo "Death Certificate holder's data inserted successfully.<br>";
    } else {
        echo "Error inserting into dcertholders table: " . $stmt1->error;
    }

    // Prepare and bind for requesters table
    $stmt2 = $conn->prepare("INSERT INTO requesters (
        relationship, last_name, first_name, middle_name, copies, purpose
    ) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt2->bind_param("sssiss", $reqRelationship, $reqLastName, $reqFirstName, $reqMiddleName, $copies, $reqPurpose);

    if ($stmt2->execute()) {
        echo "Requester's data inserted successfully.<br>";
    } else {
        echo "Error inserting into requesters table: " . $stmt2->error;
    }

    // Close statements
    $stmt1->close();
    $stmt2->close();
    header("Location: delivery.html");
} else {
    echo "Form not submitted.";
}

// Close connection
$conn->close();
?>
