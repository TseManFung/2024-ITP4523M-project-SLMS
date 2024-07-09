<?php
require_once '../db/dbconnect.php';

function return_error($message)
{
    http_response_code(400);
    echo $message;
    exit;
}

if (isset($_POST["sparePartNum"])) {
    //edit
    //$category = $_POST['category'];
    $sparePartName = $_POST['sparePartName'];
    $sparePartNumber = $_POST['sparePartNum'];
    $sparePartDescription = $_POST['sparePartDescription'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $quantity = $_POST['Quantity'];
    $response = [];

    // if any file uploaded
    if ((file_exists($_FILES['fileToUpload']['tmp_name']) && is_uploaded_file($_FILES['fileToUpload']['tmp_name']))) {
        $target_dir = "../../images/item/";
        $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

        $number = substr($sparePartNumber, 1);
        $FileName = (ord(substr($sparePartNumber, 0, 1)) - 64) . $number . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

        $target_file = $target_dir . $FileName;
        $uploadOk = 1;
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            return_error("File is not an image.");
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            return_error("Sorry, your file is too large.");
        }
        // Allow certain file formats
        $allowed_formats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_formats)) {
            return_error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return_error("Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $sql = "UPDATE `spare` set `sparePartImage` = '$target_file' WHERE `sparePartNum` = '$sparePartNumber';";
                $conn->query($sql);

                $response["uploadSuccess"] = "true";
                //echo json_encode($response);
            } else {
                http_response_code(500);
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    $sql = "UPDATE `spare`
        SET
        `sparePartDescription` = '" . $_POST['sparePartDescription'] . "',
        `weight` = " . $_POST['weight'] . ",
        `price` = " . $_POST['price'] . "
        WHERE `sparePartNum` = '" . $_POST['sparePartNum'] . "';";
    $conn->query($sql);
    $sql = "UPDATE `spareqty`
        SET
        `stockItemQty` = " . $_POST['Quantity'] . "
        WHERE `sparePartNum` = '" . $_POST['sparePartNum'] . "';";
    $conn->query($sql);
    $response["sparePartName"] = $sparePartName;
    echo json_encode($response);
} else {
    if (!isset($_POST['category']) || !isset($_POST['sparePartName']) || !isset($_POST['sparePartDescription']) || !isset($_POST['weight']) || !isset($_POST['price']) || !isset($_POST['Quantity']) || !isset($_FILES['fileToUpload'])) {
        return_error("Missing required field(s)." . var_dump($_POST));
    }

    $category = $_POST['category'];
    $sparePartName = $_POST['sparePartName'];
    $sparePartDescription = $_POST['sparePartDescription'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $quantity = $_POST['Quantity'];

    $sql = "SELECT max(sparePartNum) FROM spare where category = '$category';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    //  max(sparePartNum) = A00001 +1 -> A00002
    $code = $row['max(sparePartNum)'];
    $number = (int) substr($code, 1);
    $sparePartNumber = $category . str_pad($number + 1, 5, '0', STR_PAD_LEFT);

    $newFileName = (ord($category) - 64) . str_pad($number + 1, 5, '0', STR_PAD_LEFT) . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

    $target_dir = "../../images/item/";
    $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . $newFileName;
    $uploadOk = 1;



    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        return_error("File is not an image.");
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        return_error("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowed_formats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_formats)) {
        return_error("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return_error("Sorry, your file was not uploaded.");
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Simulate spare part number generation

            $response = [
                "sparePartName" => $sparePartName,
                "sparePartNumber" => $sparePartNumber
            ];
            $sql = "INSERT INTO `projectdb`.`spare`
    (`sparePartNum`,
    `category`,
    `sparePartName`,
    `sparePartImage`,
    `sparePartDescription`,
    `weight`,
    `price`)
    VALUES
    ('$sparePartNumber',
    '$category',
    '$sparePartName',
    '$target_file',
        '$sparePartDescription',
        $weight,
        $price);";
            $conn->query($sql);
            $sql = "INSERT INTO `projectdb`.`spareqty`
    (`sparePartNum`,
    `stockItemQty`)
    VALUES
    ('$sparePartNumber',
    $quantity);";
            $conn->query($sql);


            echo json_encode($response);
        } else {
            http_response_code(500);
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
