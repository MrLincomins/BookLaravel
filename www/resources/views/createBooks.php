<?php require_once "layout/header.php"; ?>

<body class="app">
<div id="loader" class="loader"></div>
<section class="tab-components" id="app">
    <div v-show="popupStatus === 'success'" class="alert alert-success mt-3" role="alert">
        {{ successMessage }}
    </div>

    <div v-show="popupStatus === 'error'" class="alert alert-danger mt-3" role="alert">
        {{ errorMessage }}
    </div>
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
                    <form action="/books/create" method="POST" @submit="addBook">
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- input style start -->
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Поля ввода</h6>
                                    <div class="input-style-2">
                                        <label>Название книги</label>
                                        <input v-model="bookData.tittle" type="text" placeholder="Название книги"/>
                                        <span class="icon"> <i class="lni lni-bookmark"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Автор</label>
                                        <input v-model="bookData.author" type="text" placeholder="Автор"/>
                                        <span class="icon"> <i class="lni lni-user"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Год</label>
                                        <input v-model="bookData.year" type="text" placeholder="Год"/>
                                        <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="select-style-1">
                                        <label>Выбрать жанр</label>
                                        <div class="select-position">
                                            <select class="light-bg" v-model="bookData.genre">
                                                <?php foreach ($genres as $genre): ?>
                                                    <option
                                                        value="<?php echo $genre["genre"]; ?>"><?php echo $genre["genre"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end select -->
                                    <div class="input-style-2">
                                        <label>ISBN</label>
                                        <input v-model="bookData.isbn" type="text" placeholder="ISBN"/>
                                        <span class="icon"> <i class="lni lni-paperclip"></i> </span>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <label>Число книг</label>
                                        <input v-model="bookData.count" type="text" placeholder="Число книг"/>
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
    </div>
</section>
<script>
    new Vue({
        el: '#app',
        data: {
            successMessage: '',
            errorMessage: '',
            popupStatus: null,
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
                this.showLoader();

                this.bookData.year = parseInt(this.bookData.year);
                this.bookData.isbn = parseInt(this.bookData.isbn);

                axios.post('/books/create', this.bookData)
                    .then(response => {
                        if (response.data.status) {
                            this.successMessage = response.data.message;
                            this.popupStatus = 'success';
                        } else {
                            this.errorMessage = response.data.message;
                            this.popupStatus = 'error';
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        this.errorMessage = 'Ошибка';
                        this.popupStatus = 'error';
                    })
                    .finally(() => {
                        this.hideLoader();
                    });
            },

            showLoader() {
                document.getElementById('loader').style.display = 'block';
            },
            hideLoader() {
                document.getElementById('loader').style.display = 'none';
            }
        }
    },
    })
</script>
</body>

<?php require_once "layout/footer.php"; ?>

