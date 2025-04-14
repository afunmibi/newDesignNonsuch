<?php
require "../backend/connection.php";

// Initialize search variable
$search = "";
if (isset($_GET['search']) && !empty($_GET['my_search'])) {
    $search = $con->real_escape_string($_GET['my_search']);
    $sql = "SELECT * FROM enrolment WHERE CONCAT(sname, policy_no, oname, phone_no) LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM enrolment";
}
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollee Details</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Enrollee Details</h1>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <a href="../mqams/download_excel.php" class="btn btn-success">
                    <i class="fas fa-download me-2"></i> Download Spreadsheet
                </a>
                <a href="enrolment.php" class="btn btn-primary ms-2">
                    <i class="fas fa-user-plus me-2"></i> Add New Enrollee
                </a>
            </div>
            <div class="search-form">
                <form action="" method="get" class="d-flex">
                    <input type="text" class="form-control me-2" name="my_search" placeholder="Search Enrollees" value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-outline-secondary" name="search">
                        <i class="fas fa-search"></i> Search
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Surname</th>
                        <th>Other Names</th>
                        <th>Policy No.</th>
                        <th>Phone</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['oname']) . "</td>";
                            echo "<td><a href='vet_bills.php'>" . htmlspecialchars($row['policy_no'] . '/' . $row['id'] . '/' . $row['plan_type'] . '/' . $row['no_of_dependant']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($row['phone_no']) . "</td>";
                            echo "<td><img src='../uploads/" . htmlspecialchars($row['photo']) . "' alt='Enrollee Photo' width='50'></td>";
                            echo "<td>" . htmlspecialchars($row['reg_status']) . "</td>";
                            echo "<td>";
                            echo "<a href='card.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-success btn-sm me-1'><i class='fas fa-eye'></i> View</a>";
                            echo "<a href='update.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-sm me-1'><i class='fas fa-edit'></i> Edit</a>";
                            echo "<a href='delete.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No enrollees found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="#" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Back</a>
            </div>
    </div>

    <script src="https://kit.fontawesome.com/your_fontawesome_kit.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz2" crossorigin="anonymous"></script>
</body>
</html>