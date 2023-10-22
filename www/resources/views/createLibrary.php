<?php require_once "layout/header.php"; ?>
    <body>
    <section class="tab-components">
        <div class="container-fluid offset-md-1">
            <section class="table-components">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Создание библиотеки</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-elements-wrapper">
                        <form action="/library" method="POST">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Поля ввода</h6>
                                        <div class="input-style-2">
                                            <label>Название библиотеки</label>
                                            <input name="name" type="text" placeholder="Название библиотеки"/>
                                            <span class="icon"> <i class="lni lni-key"></i> </span>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Выберите логотип для библиотеки</label>
                                            <input type="file" class="form-control"
                                                   name="libraryImg"
                                                   aria-label="Загрузка">
                                        </div>
                                        <div class="input-style-1">
                                            <label>Описание библиотеки</label>
                                            <textarea name="description" maxlength="500" placeholder="описание" rows="5"></textarea>
                                        </div>
                                        <div class="input-style-2">
                                            <label>Школа/Организация</label>
                                            <input name="organization" type="text" placeholder="Название школы/организации"/>
                                            <span class="icon"> <i class="lni lni-key"></i> </span>
                                        </div>
                                        <!-- end input -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                        type="submit">
                                                    Создать
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end button -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </section>
    </body>
<?php require_once "layout/footer.php"; ?>
