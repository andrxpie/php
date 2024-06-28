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
        <tr class="text-center">
            <th scope="col">#</th>
            <th scope="col">Фото</th>
            <th scope="col">П.І.Б.</th>
            <th scope="col">Телефон</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody class="text-center">
        <?php
        $sql = 'SELECT * FROM tbl_users';
        foreach ($pdo->query($sql) as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $image = "/".MEDIA."/".$row['image'];
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
                <td>
                <button class='btn btn-danger' data-delete='${id}'>Delete</button>
</td>
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
<div class="modal" id="dialogDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Підтвердіть операцію</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ви дійсно бажаєте видалити елемент?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                <button type="button" class="btn btn-danger" id="dialogDeleteConfirm">Видалити</button>
            </div>
        </div>
    </div>
</div>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dialogDelete = new bootstrap.Modal("#dialogDelete");
        const deleteButtons = document.querySelectorAll('[data-delete]');
        let deletedValue;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                deletedValue = String(event.target.getAttribute('data-delete'));
                console.log(`Delete item with ID: ${deletedValue}`);
                dialogDelete.show();
            });
        });

        const dialogDeleteConfirm = document.getElementById("dialogDeleteConfirm");
        dialogDeleteConfirm.addEventListener("click", function () {
            const headers = {
                'Content-Type': 'multipart/form-data',
            };
            axios.post("/delete.php", {
                id: deletedValue
            }, { headers })
                .then(resp => {
                    console.log("Delete is good");
                    window.location.reload();
                });
        });
    });
</script>
</body>
</html>