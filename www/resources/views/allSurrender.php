<?php require_once "layout/header.php";
?>

<body>
<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Книги взятые из библиотеки</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <h6 class="mb-10">Взятые книги</h6>
                        <p class="text-sm mb-20">
                            Все книги взятые учениками находятся тут
                        </p>
                        <div class="table-wrapper table-responsive">
                            <table class="table striped-table">
                                <thead>
                                <tr>
                                    <th><h6>Название книги</h6></th>
                                    <th><h6>Автор</h6></th>
                                    <th><h6>Год</h6></th>
                                    <th><h6>ISBN</h6></th>
                                    <th><h6>ID</h6></th>
                                    <th><h6>ФИО</h6></th>
                                    <th><h6>Класс</h6></th>
                                    <th><h6>Дата конца резервации</h6></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($books as $i => $book): ?>
                                    <tr>
                                        <td class="min-width">
                                            <div class="lead">
                                                <div class="lead-image bgc-img">
                                                    <img
                                                        src="<?php echo $book['picture'] ?>"
                                                        alt=""
                                                        class="lup"
                                                    />

                                                </div>
                                                <div class="lead-text">

                                                    <p><?php echo $book['tittle']; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p><?php echo $book['author']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $book['year']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php  echo $book['isbn']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $users[$i]['id']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $users[$i]['name']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $users[$i]['class']; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $surrenders[$i]['date']; ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- end table -->
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
</section>
</body>
<?php require_once "layout/footer.php"; ?>
