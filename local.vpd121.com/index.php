<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/site.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/navbar.php"; ?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php"; ?>


<h1 class="text-center">List users:</h1>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Foto</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT id, name, email, image FROM users;";
        if (isset($dbh))
        {
            $command = $dbh->query($sql);
            foreach ($command as $row)
            {
                $name = $row["name"];
                $id = $row["id"];
                $email = $row["email"];
                $image = $row["image"];

                echo "        
                        <tr>
                            <th>$id</th>
                            <td><img src='$image' width='50'/></td>
                            <td>$name</td>
                            <td>$email</td>
                            <td>
                                <a href='/delete.php?id=$id' class='text-danger' data-delete>Delete</a>
                            </td>                    
                        </tr>                
                       ";
            }
        }
        ?>
        </tbody>
    </table>
</div>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/modal/deleteModal.php"; ?>
<script src="/js/bootstrap.js"></script>


    <script>
        window.addEventListener("load", function() {
        const btns = document.querySelectorAll("[data-delete]");
        let hrefDelete = ""; //Адреса по якій потрібно провести видалення
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
        for (i=0; i<btns.length; i++) {
        btns[i].onclick=function(e) {
        e.preventDefault();
        hrefDelete=this.href;
        deleteModal.show();
    }
    }
        document.getElementById("modalDeleteYes").onclick = function () {
        console.log("DELETE URL = ", hrefDelete);
        axios.post(hrefDelete).then(resp => {
        deleteModal.hide();
        location.reload();
    });
    }
    });
</script>

</body>
</html>
