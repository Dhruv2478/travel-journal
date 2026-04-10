<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Journal Entries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/journal.css">
    <style>
        .entries-container { max-width: 1000px; margin: 50px auto; padding: 20px; background: #fff; 
        border-radius: 12px; box-shadow: 0 5px 25px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #0a3142; color: white; padding: 15px; text-align: left; }
        td { padding: 12px; border: 1px solid #ddd; }
        .no-data { padding: 40px; text-align: center; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="entries-container">
            <h1 style="color: #0a3142;">My Journal Entries</h1>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Destination</th>
                        <th>Experience</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 1. Point to the FOLDER where the entries live
                    $dir = '../xml/my_entries/';
                    $xslFile = '../xsl/my_entries.xsl';

                    // 2. Check if the folder exists
                    if (is_dir($dir)) {
                        // 3. Get all .xml files inside that folder
                        $files = glob($dir . "*.xml");

                        if (count($files) > 0) {
                            $xsl = new DOMDocument();
                            if (file_exists($xslFile)) {
                                $xsl->load($xslFile);
                                $proc = new XSLTProcessor();
                                $proc->importStyleSheet($xsl);

                                // 4. Loop through every file found
                                foreach ($files as $file) {
                                    $xml = new DOMDocument();
                                    // Load the specific file 
                                    if ($xml->load($file)) {
                                        echo $proc->transformToXML($xml);
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='3' class='no-data'>Error: entries.xsl not found in /xsl/ folder.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='no-data'>No entry files found in the folder.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='no-data'>Folder '../xml/my_entries.xml/' not found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div style="text-align:center; margin-top: 20px;">
                <a href="../html/add_entries.html" class="btn-action btn-submit-xml" style="text-decoration:none; color:white; 
                padding:10px 20px; display:inline-block; 
                background-color:#f26c4f; border-radius:5px;">Add New Entry</a>
                <br><br>
                <a href="journal.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Journal
                </a>
            </div>
        </div>
    </div>
</body>
</html>