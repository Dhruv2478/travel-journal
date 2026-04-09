<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Favourites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/destination.css">
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <h1 style="color: #0a3142;"><i style="color: #f26c4f;"></i> My Favourite destinations</h1>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white;">
            <thead>
                <tr style="background: #0a3142; color: white; text-align: left;">
                    <th style="padding: 15px; border: 1px solid #0a3142;">Destination</th>
                    <th style="padding: 15px; border: 1px solid #0a3142;">Location</th>
                    <th style="padding: 15px; border: 1px solid #0a3142;">Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dir = '../xml/';
                if (is_dir($dir)) {
                    $files = glob($dir . "*.xml");
                    if (count($files) > 0) {
                        $xsl = new DOMDocument();
                        $xsl->load('../xsl/favourites.xsl');
                        $proc = new XSLTProcessor();
                        $proc->importStyleSheet($xsl);

                        foreach ($files as $file) {
                            $xml = new DOMDocument();
                            $xml->load($file);

                            echo $proc->transformToXML($xml);
                        }
                    } else {
                        echo "<tr><td colspan='3' style='padding:20px; text-align:center;'>No favourites found.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            <a href="destination.php" class="btn-action" style="display:inline-block; width:auto; padding:10px 20px; text-decoration:none;">
                <i class="fas fa-plus"></i> Add More
            </a>
        </div>
    </div>
</body>
</html>