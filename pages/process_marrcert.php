<?php
// Database connection details
$host = "localhost";  // MySQL host
$dbname = "docxpress"; // database name
$user = "root";        // username
$password = "";        // password

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Enable error reporting for MySQLi
$conn->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

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
    $husbandLastName = $_POST['husbandLastName'] ?? '';
    $husbandFirstName = $_POST['husbandFirstName'] ?? '';
    $husbandMiddleName = $_POST['husbandMiddleName'] ?? '';
    $wifeLastName = $_POST['wifeLastName'] ?? '';
    $wifeFirstName = $_POST['wifeFirstName'] ?? '';
    $wifeMiddleName = $_POST['wifeMiddleName'] ?? '';
    $marriageDate = $_POST['marriageDate'] ?? null;
    $marriagePlace = $_POST['marriagePlace'] ?? '';
    $reqRelationship = $_POST['reqRelationship'] ?? '';
    $reqLastName = $_POST['reqLastName'] ?? '';
    $reqFirstName = $_POST['reqFirstName'] ?? '';
    $reqMiddleName = $_POST['reqMiddleName'] ?? '';
    $copies = isset($_POST['copies']) ? (int)$_POST['copies'] : 1;
    $reqPurpose = $_POST['reqPurpose'] ?? '';

    // Prepare and bind for mcertholders table
    $stmt1 = $conn->prepare("INSERT INTO mcertholders (
        last_name, first_name, middle_name, suffix, sex, birthday, 
        husband_last_name, husband_first_name, husband_middle_name,
        wife_last_name, wife_first_name, wife_middle_name,
        marriage_date, marriage_place
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt1) {
        die("Error in preparing mcertholders query: " . $conn->error);
    }

    $stmt1->bind_param("ssssssssssssss", 
        $lastName, $firstName, $middleName, $suffix, $sex, $birthday, 
        $husbandLastName, $husbandFirstName, $husbandMiddleName,
        $wifeLastName, $wifeFirstName, $wifeMiddleName, 
        $marriageDate, $marriagePlace
    );

    if ($stmt1->execute()) {
        echo "Marriage Certificate holder's data inserted successfully.<br>";
    } else {
        echo "Error inserting into mcertholders table: " . $stmt1->error;
    }

    // Prepare and bind for requesters table
    $stmt2 = $conn->prepare("INSERT INTO requesters (
        relationship, last_name, first_name, middle_name, copies, purpose
    ) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt2) {
        die("Error in preparing requesters query: " . $conn->error);
    }

    $stmt2->bind_param("ssssss", 
        $reqRelationship, $reqLastName, $reqFirstName, $reqMiddleName, $copies, $reqPurpose
    );

    if ($stmt2->execute()) {
        echo "Requester's data inserted successfully.<br>";
    } else {
        echo "Error inserting into requesters table: " . $stmt2->error;
    }

    // Close statements
    $stmt1->close();
    $stmt2->close();

    // Redirect to delivery page
    header("Location: delivery.html");
    exit();
} else {
    echo "Form not submitted.";
}

// Close connection
$conn->close();
?>
