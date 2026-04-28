<?php
session_start();

// Check authentication
if (!isset($_SESSION['user']) && !isset($_SESSION['parent_auth'])) {
    header("Location: index.php");
    exit;
}

// Get the record ID from URL
if (!isset($_GET['id']) || !isset($_GET['date'])) {
    header("Location: records.php?error=Invalid record");
    exit;
}

$record_id = $_GET['id'];
$record_date = $_GET['date'];

// For students, only allow editing their own records
if (isset($_SESSION['student_id']) && $record_id != $_SESSION['student_id']) {
    header("Location: records.php?error=Unauthorized");
    exit;
}

// Read current record
$file = fopen("data/attendance.csv", "r");
$record = null;
$line_number = 0;
$found = false;

while (($row = fgetcsv($file)) !== FALSE) {
    $row_date = date("Y-m-d", strtotime($row[3]));
    if ($row[0] == $record_id && $row_date == $record_date) {
        $record = $row;
        $found = true;
        break;
    }
    $line_number++;
}
fclose($file);

if (!$found) {
    header("Location: records.php?error=Record not found");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = trim(htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8'));
    
    // Validate status
    if (!in_array($new_status, ['Present', 'Absent', 'Late'])) {
        header("Location: edit_attendance.php?id=" . urlencode($record_id) . "&date=" . urlencode($record_date) . "&error=Invalid status");
        exit;
    }
    
    // Read all records
    $file = fopen("data/attendance.csv", "r");
    $records = [];
    while (($row = fgetcsv($file)) !== FALSE) {
        $records[] = $row;
    }
    fclose($file);
    
    // Update the specific record
    $records[$line_number][2] = $new_status;
    
    // Write back to file
    $file = fopen("data/attendance.csv", "w");
    foreach ($records as $r) {
        fputcsv($file, $r);
    }
    fclose($file);
    
    header("Location: records.php?msg=Record updated successfully");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Attendance</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Attendance Record</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Student ID:</label>
                <input type="text" value="<?php echo htmlspecialchars($record[0]); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" value="<?php echo htmlspecialchars($record[1]); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Date:</label>
                <input type="text" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($record[3]))); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="Present" <?php echo $record[2] === 'Present' ? 'selected' : ''; ?>>Present</option>
                    <option value="Absent" <?php echo $record[2] === 'Absent' ? 'selected' : ''; ?>>Absent</option>
                    <option value="Late" <?php echo $record[2] === 'Late' ? 'selected' : ''; ?>>Late</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit">Update</button>
                <a href="records.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>