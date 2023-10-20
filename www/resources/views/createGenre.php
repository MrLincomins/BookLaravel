<?php require_once "layout/header.php"; ?>
    <div class="container px-4">
        <div class="row gx-5">

            <div class="col-5">
                <h1 class="p-2 border">Добавить жанр</h1>
                <form action="/books/genre" method="POST">
                    <div class="form-group p-3 border">
                        <label for="exampleInputEmail1">Название жанра</label>
                        <label>
                            <input type="text" name="genre" class="form-control"

                                   autocomplete="off">
                        </label>
                        <div class="form-group" style="display: inline-block">
                            <button class="btn btn-primary" name="submit" type="submit">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 mt-4   ">
                <div class="card-style mb-30">
                    <h6 class="mb-10">Жанры</h6>
                    <p class="text-sm mb-20">
                        Здесь показаны жанры которые добавлены в библиотеку
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                            <tr>
                                <th><h6>Название</h6></th>
                            </tr>
                            <!-- end table row-->
                            </thead>
                            <tbody>
                            <?php foreach ($genres as $genre): ?>
                            <tr>
                                <td>
                                    <p><?= $genre['genre'] ?></p>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once "layout/footer.php"; ?>
