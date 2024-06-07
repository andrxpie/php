<?php
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include_once $_SERVER["DOCUMENT_ROOT"]."/connection_database.php";
    $folderName = $_SERVER['DOCUMENT_ROOT'].'/'. MEDIA;
    if (!file_exists($folderName)) {
        mkdir($folderName, 0777);
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' .$ext;
    $uploadfile = $folderName ."/". $fileName;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    $name =  $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = 'INSERT INTO tbl_users (name, email, phone, image) VALUES (:name, :email, :phone, :image)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'image' => $fileName]);

    header('Location: /');
    exit();
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
                    <label for="name" class="form-label">П.І.Б.</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">
                        П.І.Б. не може бути порожнім.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        Email не може бути порожнім.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Номер телефону</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                    <div class="invalid-feedback">
                        Номер телефону не може бути порожнім.
                    </div>
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
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

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