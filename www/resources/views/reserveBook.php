<?php require_once "layout/header.php"; ?>
<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap mb-30">
                    <h2 class="mr-40">Резервация книг</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">books</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                reserve
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-wrapper">
        <div class="row">
            <div class="col-7">
                <div class="invoice-card card-style mb-6">
                    <div class="invoice-header">
                        <div class="invoice-address">
                            <div class="address-item pt-3">
                                <h1> <?php echo $book->tittle ?> </h1>
                                <p class="text">
                                    <span class="text-medium">Автор:</span>
                                    <?php echo $book->author; ?>
                                </p>
                                <p class="text">
                                    <span class="text-medium">Жанр:</span>
                                    <?php echo $book->genre; ?>
                                </p>
                                <p class="text">
                                    <span class="text-medium">Год:</span>
                                    <?php echo $book->year; ?>
                                </p>
                            </div>
                            <div class="invoice-for">
                            </div>
                            <div class="logo col-14">
                                <img
                                    src="<?php echo $book->picture ?>"
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>

                    <div class="invoice-action">
                        <ul
                            class="
                        d-flex
                        flex-wrap
                        align-items-center
                        justify-content-center
                      "
                        >
                            <li class="m-2">
                                <a
                                    href="/books"
                                    class="main-btn primary-btn-outline btn-hover"
                                >
                                    Отмена
                                </a>
                            </li>
                            <li class="m-2">
                                <form method="post" action="/books/reserve/<?php echo $book->id ?>">
                                    <button class="main-btn primary-btn btn-hover" type="submit">
                                        Зарезервировать
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<?php require_once "layout/footer.php"; ?>
