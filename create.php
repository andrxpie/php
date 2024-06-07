<?php
include_once "connection_database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addNewUser($pdo);
}

function addNewUser($pdo) {
    if (isset($_POST['name'], $_POST['email'], $_POST['phone']) && isset($_FILES['image'])) {
        $name = $_POST['name'];
        $email = $_POST['email'] . '@supermail.com';
        $phone = $_POST['phone'];

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = $_FILES['image'];
        $uploadFile = MEDIA . uniqid() . '.' .$ext;

        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            $sql = "INSERT INTO tbl_users (name, image, email, phone) VALUES (:name, :image, :email, :phone)";
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute(['name' => $name, 'image' => $uploadFile, 'email' => $email, 'phone' => $phone]);
                header('Location: //localhost/index.php');
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Failed to upload photo.";
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New user</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<main>
    <div class="container mt-5">
        <div class="row">
            <h1>Add New User</h1>
            <form class="col-md-6 offset-md-3 needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-3">
                            <label for="image" class="form-label">
                                <img id="preview" src="/media/no-photo.png" width="100%" alt="фото">
                            </label>
                        </div>
                        <div class="mb-3 col-md-9">
                            <input type="file" class="form-control" id="image" name="image" aria-describedby="emailHelp" accept="image/*" onchange="previewImage(event)">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success me-2">Створити</button>
                    <a href="/" class="btn btn-primary">Скасувати</a>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>
</html>
