<?php require_once  "layout/header.php"; ?>

<body class="app">
<section class="tab-components">
    <div class="container-fluid">
        <section class="table-components">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title mb-30">
                                <h2>Добавить книгу</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-elements-wrapper">
                    <form action="/books/create" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- input style start -->
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Поля ввода</h6>
                                    <div class="input-style-2">
                                        <label>Название книги</label>
                                        <input name="tittle" type="text" placeholder="Название книги"/>
                                        <span class="icon"> <i class="lni lni-bookmark"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Автор</label>
                                        <input name="author" type="text" placeholder="Автор"/>
                                        <span class="icon"> <i class="lni lni-user"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Год</label>
                                        <input name="year" type="text" placeholder="Год"/>
                                        <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="select-style-1">
                                        <label>Выбрать жанр</label>
                                        <div class="select-position">
<<<<<<< Updated upstream
                                            <select class="light-bg" name="genre">
                                                <?php foreach ($genres as $genre): ?>
                                                    <option
                                                        value="<?php echo $genre["genre"]; ?>"><?php echo $genre["genre"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
=======
                                                <select class="light-bg" v-model="bookData.genre">
                                                    <?php foreach ($genres as $genre): ?>
                                                        <option value="<?php echo $genre["genre"]; ?>"><?php echo $genre["genre"]; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
>>>>>>> Stashed changes
                                        </div>
                                    </div>
                                    <!-- end select -->
                                    <div class="input-style-2">
                                        <label>ISBN</label>
                                        <input name="isbn" type="text" placeholder="ISBN"/>
                                        <span class="icon"> <i class="lni lni-paperclip"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Число книг</label>
                                        <input name="count" type="text" placeholder="Число книг"/>
                                        <span class="icon"> <i class="lni lni-calculator"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover w-100 text-center"
                                                    type="submit">
                                                Добавить
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
<<<<<<< Updated upstream
=======
    </div>
</section>

<script>
    new Vue({
        el: '#app',
        data: {
            successMessage: '',
            errorMessage: '',
            bookData: {
                tittle: '',
                author: '',
                year: '',
                genre: '',
                isbn: '',
                count: '',
            },
        },
        methods: {
            addBook(event) {
                event.preventDefault();

                this.bookData.year = parseInt(this.bookData.year);
                this.bookData.isbn = parseInt(this.bookData.isbn);

                axios.post('/books/create', this.bookData)
                    .then(response => {
                        if (response.data.status === true) {
                            this.showSuccessPopup(response.data.message);
                        } else {
                            this.showErrorPopup(response.data.message);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            showSuccessPopup(message) {
                this.successMessage = message;
                const successPopup = new bootstrap.Alert(document.getElementById('successPopup'));
                successPopup.classList.remove('d-none');
                setTimeout(() => {
                    successPopup.classList.add('d-none');
                    this.successMessage = '';
                }, 5000);
            },
            showErrorPopup(message) {
                this.errorMessage = message;
                const errorPopup = new bootstrap.Alert(document.getElementById('errorPopup'));
                errorPopup.classList.remove('d-none');
                setTimeout(() => {
                    errorPopup.classList.add('d-none');
                    this.errorMessage = '';
                }, 5000);
            },
        },
    });
</script>
>>>>>>> Stashed changes
</body>

<?php require_once  "layout/footer.php"; ?>

