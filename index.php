<!DOCTYPE html>
<html>
<head>
    <title>Hotel Guest Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #faf5fcff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background:  pink;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 50px rgba(10, 10, 10, 0.1);
            width: 600%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input, textarea {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #664cafff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        #message {
            margin-top: 10px;
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hotel Guest Registration</h1>

    <!-- Form para mag-add ng guest -->
    <form method="POST" action="">
        <label>First Name:</label>
        <input type="text" name="first_name" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" required>

        <label>Email:</label>
        <input type="email" name="email">

        <label>Phone:</label>
        <input type="text" name="phone">

        <label>Address:</label>
        <input type="text" name="address">

        <label>Date of Birth:</label>
        <input type="date" name="birth_date">

        <button type="submit" name="register_guest">Register Guest</button>
    </form>

    <h3>Registered Guests</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Birth Date</th>
            <th>Action</th>
        </tr>

        <?php
        include 'db_connect.php';

        // Insert guest
        if(isset($_POST['register_guest'])){
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $birth_date = $_POST['birth_date'];

            $sql = "INSERT INTO guests (first_name, last_name, email, phone, address, birth_date) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $address, $birth_date);
            $stmt->execute();
            $stmt->close();

            header("Location: index.php");
            exit();
        }

        // Delete guest
        if(isset($_GET['delete_id'])){
            $delete_id = $_GET['delete_id'];
            $sql = "DELETE FROM guests WHERE guest_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $delete_id);
            $stmt->execute();
            $stmt->close();
            header("Location: index.php");
            exit();
        }

        // Display guests
        $sql = "SELECT * FROM guests ORDER BY guest_id DESC";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['guest_id']."</td>";
                echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>".$row['address']."</td>";
                echo "<td>".$row['birth_date']."</td>";
                echo "<td><a href='index.php?delete_id=".$row['guest_id']."' 
                        onclick='return confirm(\"Are you sure you want to delete this guest?\")' 
                        style='color: red;'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No registered guests yet.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
