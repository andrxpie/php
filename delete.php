<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";
    $id = $_POST["id"];
    try {
        $sql = 'SELECT image FROM tbl_users WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result) {
            $fileName = $result["image"];
            $folderName = $_SERVER['DOCUMENT_ROOT'].'/'.MEDIA;
            $uploadfile = $folderName ."/". $fileName;

            if (file_exists($uploadfile)) {
                if (unlink($uploadfile)) {
                    echo "File '$uploadfile' deleted successfully.";
                }
            }
        }
        $sql = 'DELETE FROM tbl_users WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Record deleted successfully.";
        } else {
            echo "No record found with the given ID.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}