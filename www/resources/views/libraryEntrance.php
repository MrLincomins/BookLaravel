<?php require_once "layout/header.php"; ?>

<body>
<section class="tab-components">
    <div class="container-fluid">
        <section class="table-components" id="app">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title mb-30">
                                <h2>Войти в библиотеку</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-elements-wrapper">
                    <form method="post" action="/library/entrance">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Поля ввода</h6>
                                    <div class="input-style-2">
                                        <label>Введите код библиотеки</label>
                                        <input name="unique_key" type="text" placeholder="код" />
                                        <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                    </div>
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover w-100 text-center" type="submit">
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
    </div>
</section>
</body>


<?php require_once "layout/footer.php"; ?>
