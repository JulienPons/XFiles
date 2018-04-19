<?php include('inc/head.php'); ?>

<?php

if(isset($_POST["content"])) {
    $fileToModify = $_POST["file"];
    $fileToModifyOpen = fopen($fileToModify, "w");
    fwrite($fileToModifyOpen, $_POST["content"]);
    fclose($fileToModifyOpen);
}

if(isset($_POST["delete-file"])) {
    $fileToDelete = $_POST["delete-file"];
    unlink($fileToDelete);
}

if(isset($_POST["delete-dir"])) {
    $dirToDelete = $_POST["delete-dir"];
    rmdir($dirToDelete);
}

$dirFiles = 'files';

function dirToArray ($dirFiles)
{
    $files = scandir($dirFiles);
    echo '<ul>';
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (is_dir($dirFiles . '/' . $file)) {
                echo '<li>';
                echo $file;
                if(count(scandir($dirFiles . '/' . $file)) > 2) {
                    $Delete = 'This directory is not empty. Removal is not allow';
                
                } else {
                    $Delete = '<input type="submit" value="Delete this directory">';
                }
                ?>
                <form action="" method="post">
                    <input type="hidden" name="delete-dir" value="<?php echo $dirFiles . '/' . $file ?>">
                    <?php echo $Delete; ?>
                </form>
                <?php
                $file = $dirFiles . '/' . $file;
                dirToArray($file);
            } else {
                echo '<li>';
                if (preg_match ('/.txt/', $file) || preg_match ('/.html/', $file)) {
                    echo '<a href=\'?f=' . $dirFiles . '/' . $file . '\'>';
                }
                echo $file;
                echo '</a> '; ?>
                <form action="" method="post">
                    <input type="hidden" name="delete-file" value="<?php echo $dirFiles . '/' . $file ?>">
                    <input type="submit" value="Delete this file">
                </form>
                <?php
            }
        }
    }
    echo '</ul>';
}

dirToArray($dirFiles);



if(isset($_GET["f"])) {
$fileToModify = $_GET["f"];
$content = file_get_contents($fileToModify);

?>
    <form action="index.php" method="post">
        <textarea name="content" id="content" style="width: 100%; height: 200px;"><?php echo $content?></textarea>
        <input type="hidden" name="file" value="<?php echo $_GET["f"] ?>"/>
        <input type="submit" value="Send">
    </form>
<?php
}
?>

<?php include('inc/foot.php'); ?>