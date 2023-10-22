@extends('layout.layout')

@section('content')
<body>
<div id="loader" class="loader"></div>
<section class="tab-components" id="app">
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
                    <form action="/books/create" method="POST" @submit.prevent="addBook">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Поля ввода</h6>
                                    <div class="input-style-2">
                                        <label>Название книги</label>
                                        <input v-model="bookData.tittle" type="text" placeholder="Название книги"/>
                                        <span class="icon"> <i class="lni lni-bookmark"></i> </span>
                                    </div>
                                    <div class="input-style-2">
                                        <label>Автор</label>
                                        <input v-model="bookData.author" type="text" placeholder="Автор"/>
                                        <span class="icon"> <i class="lni lni-user"></i> </span>
                                    </div>
                                    <div class="input-style-2">
                                        <label>Год</label>
                                        <input v-model="bookData.year" type="text" placeholder="Год"/>
                                        <span class="icon"> <i class="lni lni-calendar"></i> </span>
                                    </div>
                                    <div class="select-style-1">
                                        <label>Выбрать жанр</label>
                                        <div class="select-position">
                                            <select class="light-bg" v-model="bookData.genre">
                                                @foreach($genres as $genre)
                                                <option value="{{ $genre['genre'] }}">{{ $genre['genre'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="input-style-2">
                                        <label>ISBN</label>
                                        <input v-model="bookData.isbn" type="text" placeholder="ISBN"/>
                                        <span class="icon"> <i class="lni lni-paperclip"></i> </span>
                                    </div>
                                    <div class="input-style-2">
                                        <label>Число книг</label>
                                        <input v-model="bookData.count" type="text" placeholder="Число книг"/>
                                        <span class="icon"> <i class="lni lni-calculator"></i> </span>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert" :class="{ 'alert-success': isSuccess, 'alert-danger': !isSuccess }" v-if="statusMessage">
                                            @{{ statusMessage }}
                                        </div>
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover w-100 text-center" type="submit">Добавить</button>
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
<script>
    var bookData = {!! json_encode([
        'tittle' => '',
        'author' => '',
        'year' => '',
        'genre' => '',
        'isbn' => '',
        'count' => '',
    ]) !!};

    new Vue({
        el: '#app',
        data: {
            bookData: bookData,
            statusMessage: '',
            isSuccess: false,
        },
        methods: {
            addBook(event) {
                event.preventDefault();
                this.showLoader();

                this.bookData.year = parseInt(this.bookData.year);
                this.bookData.isbn = parseInt(this.bookData.isbn);

                axios.post('/books/create', this.bookData)
                    .then(response => {
                        if (response.data.status === true) {
                            this.showAlert('Книга успешно добавлена', true)
                        } else {
                            this.showAlert('Ошибка при добавлении книги', false)
                        }
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
            },
            showAlert(message, bool) {
                this.statusMessage = message;
                this.isSuccess = bool;

                setTimeout(() => {
                    this.statusMessage = '';
                    this.isSuccess = false;
                }, 4000);
            },
        }
    });
</script>
@endsection
