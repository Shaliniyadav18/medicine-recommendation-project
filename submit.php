<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the name and symptoms are set
    if (isset($_POST["name"]) && isset($_POST["symptoms"])) {
        // Sanitize input data to prevent SQL injection
        $name = $_POST["name"];
        $symptoms = $_POST["symptoms"];

        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "info_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL query to insert data
        $sql = "INSERT INTO patients (name, symptoms) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $name, $symptoms);
        $stmt->execute();
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        

        // Close the connection
        $stmt->close();
        $conn->close();

        // Redirect to a success page or display a success message
        header("Location: success.html");
        exit;
    }
    else {
        echo "Name and symptoms are not set";
    }
} else {
    echo "Form is not submitted";
}
?>
