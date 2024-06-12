<?php
// $servername = "localhost";
// //$port = 3306;
// $database = "userdata";
// $username = "root";
// $password = "nightstar#123";


// ////$conn = mysqli_connect($servername, $username, $password, $database, $port);
// $conn = mysqli_connect($servername, $username, $password, $database);

// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfully";


// mysqli_close($conn);

// //phpinfo();

// /////$sum = 5 + 6;
// /////echo $sum;



// Database connection
$servername = "localhost";
$username = "root";
$password = "nightstar#123";
$dbname = "userdata";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// CREATE operation
function createUser($name, $email) {
    global $conn;

    // Check if email already exists
    $sql_check = "SELECT * FROM users WHERE email='$email'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo "Email already exists. Cannot create user.";
        return;
    }

    $createdate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users (name, email, createdate) VALUES ('$name', '$email', '$createdate')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// READ operation
function getUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $users = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

// UPDATE operation
function updateUser($id, $name, $email) {
    global $conn;
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// DELETE operation
function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

// Usage examples
// Create a user
//createUser("John Doe2", "john@example2.com");

// Read all users
$users = getUsers();
print_r($users);

// Update a user
//updateUser(1, "Jane Doe0", "jane@example0.com");

// Delete a user
//deleteUser(2);

// Close connection
mysqli_close($conn);

?>
