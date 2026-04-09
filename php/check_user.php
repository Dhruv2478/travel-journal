<?php
header('Content-Type: text/xml');
include("../database/database_connection.php");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<user_validation_data>'; 

$field = $_GET['field'] ?? '';
$value = $_GET['value'] ?? '';

if (!empty($field) && !empty($value)) {
    echo '<check field="' . htmlspecialchars($field) . '">';

    $column = ($field === 'username') ? 'username' : 'email';
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE $column = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        echo '<status_code>taken</status_code>';
        $msg = ($field === 'username') ? "Username already exists" : "Email already registered";
        echo '<error_message>' . $msg . '</error_message>';
    } else {
        echo '<status_code>available</status_code>';
        echo '<error_message></error_message>';
    }
    
    echo '</check>';
    $stmt->close();
}
echo '</user_validation_data>';
$conn->close();
?>