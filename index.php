<?php require_once ('dbConfig.php'); 

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET time_zone = '+08:00';");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hardcoded customer data
    $customers = [
        [1, 'John', 'Doe', '123456789', 'john.doe@example.com', '123 Main St'],
        [2, 'Jane', 'Smith', '987654321', 'jane.smith@example.com', '456 Oak St'],
        [3, 'Alice', 'Johnson', '555123456', 'alice.johnson@example.com', '789 Pine St']
    ];

    // Prepare the SQL statement
    $sql = "INSERT INTO CustomersTable (CustomerID, FirstName, LastName, PhoneNumber, Email, Address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the statement for each customer
    foreach ($customers as $customer) {
        $stmt->execute($customer);
    }

    echo "Data inserted successfully!";

} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}


try {
    // Create a new PDO instance and set the timezone
    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET time_zone = '+08:00';");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch data from CustomersTable
    $sql = "SELECT CustomerID, FirstName, LastName, PhoneNumber, Email, Address FROM CustomersTable";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all rows from the result set
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Customers List</h1>
    <table>
        <tr>
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
        </tr>

        <?php
        // Check if there are any results and render them in the HTML table
        if (!empty($customers)) {
            foreach ($customers as $customer) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($customer['CustomerID']) . "</td>";
                echo "<td>" . htmlspecialchars($customer['FirstName']) . "</td>";
                echo "<td>" . htmlspecialchars($customer['LastName']) . "</td>";
                echo "<td>" . htmlspecialchars($customer['PhoneNumber']) . "</td>";
                echo "<td>" . htmlspecialchars($customer['Email']) . "</td>";
                echo "<td>" . htmlspecialchars($customer['Address']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>