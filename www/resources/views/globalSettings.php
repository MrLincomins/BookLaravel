<?php require_once  "layout/header.php"; ?>

    <body>
    <section class="tab-components">
        <div class="container-fluid">
            <section class="table-components">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Изменить данные библиотеки</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form action="/settings" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- input style start -->
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Поля ввода</h6>

                                        <div class="input-style-2">
                                            <label>Название библиотеки</label>
                                            <input name="nameLibrary" type="text" placeholder="Название библиотеки"/>
                                            <span class="icon"> <i class="mdi mdi-rename"></i> </span>
                                        </div>

                                        <div class="input-style-2">
                                            <label>Иконка библиотеки</label>
                                            <input name="image" type="file" accept="image/png"/>
                                            <span class="icon"> <i class="mdi mdi-panorama-variant-outline"></i> </span>
                                        </div>

                                        <div class="input-style-2">
                                            <label>Описание библиотеки</label>
                                            <input name="info" type="text" placeholder="Описание библиотеки"/>
                                            <span class="icon"> <i class="mdi mdi-information-outline"></i> </span>
                                        </div>

                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="submit">
                                                    Добавить
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
    </body>

<?php require_once  "layout/footer.php"; ?>
