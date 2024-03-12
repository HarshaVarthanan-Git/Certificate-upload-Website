<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $roll_number = $_POST["roll_number"];
    $section = $_POST["section"];
    $event_attended = $_POST["event_attended"];
    $name_of_event = isset($_POST["name_of_event"]) ? $_POST["name_of_event"] : ""; // Newly added field
    $company_college = $_POST["company_college"];
    $days_attended = $_POST["days_attended"];
    $from_date = $_POST["from_date"];
    $to_date = $_POST["to_date"];

    // File upload handling
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["certificate"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["certificate"]["size"] > 10000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only PDF files
    if ($fileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["certificate"]["name"])) . " has been uploaded.";
            // Rename uploaded file
            $newFileName = date("d-m-Y", strtotime($to_date)) . ".pdf";
            $renamedFile = $targetDir . $newFileName;
            rename($targetFile, $renamedFile);

            // Store form data in database
            $servername = "localhost";
            $username = "root"; // Assuming default username for XAMPP
            $password = ""; // Assuming no password for XAMPP
            $dbname = "event_registration";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL statement
            $sql = "INSERT INTO registrations (name, roll_number, section, event_attended, name_of_event, company_college, days_attended, from_date, to_date, certificate)
                    VALUES ('$name', '$roll_number', '$section', '$event_attended', '$name_of_event', '$company_college', $days_attended, '$from_date', '$to_date', '$newFileName')";

            // Execute SQL statement
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close connection
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
