<?php
include_once 'connection.php';
$error = "";
// CREATE operation
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = date('Y-m-d H:i:s');
    // Check if name and email are not empty
    if (!empty($name) && !empty($email)) {
        // Check if email already exists
        $sql_check = "SELECT * FROM users WHERE email='$email'";
        $result_check = $conn->query($sql_check);
        if ($result_check->num_rows > 0) {
            echo "Email already exists. Cannot create user.";
        } else {
            $sql = "INSERT INTO users (name, email, createdate) VALUES ('$name', '$email', '$date')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        $error = "Name and email cannot be empty.";
    }
}

// READ operation
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// UPDATE operation
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = date('Y-m-d H:i:s');

    $sql = "UPDATE users SET name='$name', email='$email', createdate='$date' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// DELETE operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>User Management</h2>

    <!-- Form to add new user -->
    <h3>Add New User</h3>
    <h1>
        <?php
        // Display error message using JavaScript alert if error is not empty
        if (!empty($error)) {
            echo $error;
        }
        ?>
    </h1>
    <form action="" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <br>

    <!-- Table to display existing users -->
    <h3>Existing Users</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Create Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $key => $user) : ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['createdate']; ?></td>
                <td>
                    <a href="index.php?edit=<?php echo $user['id']; ?>">Edit</a> |
                    <a href="index.php?delete=<?php echo $user['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Form to update user -->
    <?php if (isset($_GET['edit'])) : ?>
        <?php
        $id = $_GET['edit'];
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        ?>
        <h3>Edit User</h3>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
            <input type="submit" name="update" value="Update">
        </form>
    <?php endif; ?>
</body>

</html>