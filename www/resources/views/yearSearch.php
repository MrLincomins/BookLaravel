<?php require_once "layout/header.php"; ?>
<body>
    <section class="tab-components">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Поиск по году</h2>
                        </div>
                    </div>
                    <form action="/books/year" method="POST">
                        <div class="form-elements-wrapper">
                            <div class="row">
                                <div class="col-lg-4">
                                    <!-- input style start -->
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Введите год</h6>
                                        <div class="input-style-1">
                                            <label>Год(ОТ)</label>
                                            <input name="first" type="text" placeholder="0"
                                                   autocomplete="off">
                                        </div>
                                        <!-- end input -->
                                        <div class="input-style-1">
                                            <label>Год(ДО)</label>
                                            <input name="second" type="text" placeholder="9999"
                                                   autocomplete="off">
                                        </div>
                                        <!-- end input -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="submit">
                                                    Искать
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end input -->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-10">Найденые данные:</h6>
                                        <div class="table-wrapper table-responsive">
                                            <table class="table striped-table">
                                                <thead>
                                                <tr>
                                                    <th><h6>Название</h6></th>
                                                    <th><h6>Автор</h6></th>
                                                    <th><h6>ISBN</h6></th>
                                                    <th><h6>Жанр</h6></th>
                                                    <th><h6>Год</h6></th>
                                                    <th><h6>Кол-во на складе</h6></th>


                                                </tr>
                                                <!-- end table row-->
                                                </thead>
                                                <tbody>
                                                <?php if(empty($books)): ?>
                                                    <tr>
                                                        <td>...</td>
                                                        <td>...</td>
                                                        <td>...</td>
                                                        <td>...</td>
                                                        <td>...</td>
                                                        <td>...</td>
                                                    </tr>
                                                <?php  else: ?>
                                                    <?php foreach ($books as $book):?>
                                                        <tr>
                                                            <td><?php echo $book->tittle ?></td>
                                                            <td><?php echo $book->author ?></td>
                                                            <td><?php echo $book->isbn ?></td>
                                                            <td><?php echo $book->genre ?></td>
                                                            <td><?php echo $book->year ?></td>
                                                            <td><?php echo $book->count ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </body>
<?php require_once "layout/footer.php"; ?>
