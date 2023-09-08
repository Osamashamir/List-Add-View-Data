Certainly! To include database creation in the same PHP file, you can add the database creation code at the beginning of the file. Here's the complete PHP file that combines the database creation, adding movies, and listing favorite movies:

```php
<?php
$servername = "localhost"; // Your database server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "movie_database"; // Your database name

// Create the database if it doesn't exist
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully!<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// Create the 'movies' table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    genre VARCHAR(255),
    year INT
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table 'movies' created successfully!<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Favorite Movies</title>
</head>
<body>
    <h1>Favorite Movies List</h1>

    <?php
    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted to add a new movie
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $genre = $_POST["genre"];
        $year = $_POST["year"];

        $sql = "INSERT INTO movies (title, genre, year) VALUES ('$title', '$genre', $year)";

        if ($conn->query($sql) === TRUE) {
            echo "Movie added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Display favorite movies
    ?>
    
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Genre</th>
            <th>Year</th>
        </tr>
        <?php
        $sql = "SELECT * FROM movies";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["genre"] . "</td>";
                echo "<td>" . $row["year"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No movies found.";
        }

        $conn->close();
        ?>
    </table>

    <h2>Add a New Movie</h2>
    <form action="" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" required><br>

        <label for="year">Year:</label>
        <input type="number" name="year" required><br>

        <input type="submit" value="Add Movie">
    </form>
</body>
</html>