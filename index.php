<?php
include_once "connection_database.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<main class="col-md-10 offset-md-1">
    <h1 class="mt-3 text-center">Users</h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Фото</th>
            <th scope="col">П.І.Б.</th>
            <th scope="col">Телефон</th>
            <th scope="col">Email</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = 'SELECT * FROM tbl_users';
        foreach ($pdo->query($sql) as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $image = $row['image'];
            $email = $row['email'];
            $phone = $row['phone'];
            echo "
            <tr>
                <th scope='row'>$id</th>
                <td>
                    <img src='$image'
                         width='150'
                         alt='$name'>
                </td>
                <td>$name</td>
                <td>$phone</td>
                <td>$email</td>
            </tr>
                ";
        }
        ?>
        </tbody>
    </table>
    <a href="/create.php" class="mt-3">
        <button type="submit" class="btn btn-primary">Додати нового користувача</button>
    </a>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
