@extends('layout.layout')

@section('content')
    <body>
    <div id="loader" class="loader"></div>
    <section class="table-components" id="app">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Зарезервированные книги</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="alert" :class="{ 'alert-success': isSuccess, 'alert-danger': !isSuccess }"
                     v-if="statusMessage">
                    @{{ statusMessage }}
                </div>
            </div>
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <h6 class="mb-10">Зарезервированные книги</h6>
                            <p class="text-sm mb-20">
                                Все книги зарезервированные учениками находятся тут
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
                                        <th><h6>Управление</h6></th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(book, index) in books" :key="index">
                                        <td>
                                            <p>@{{ book.tittle }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ book.author }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ book.year }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ book.isbn }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ users[index].id }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ users[index].name }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ users[index].class }}</p>
                                        </td>
                                        <td>
                                            <p>@{{ reserves[index].date }}</p>
                                        </td>
                                        <td>
                                            <div class="action">
                                            <button type="button" class="text-danger"
                                                    @click="issuanceBook(reserves[index].id, book.id, users[index].id)">
                                                <p>Выдача книги пользователю</p>
                                            </button>
                                            <button @click="deleteReservation(reserves[index].id, book.id)" type="button"
                                                    class="text-danger">
                                                <i class="lni lni-trash-can"></i>
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
    <script>
        const app = new Vue({
            el: '.table-components',
            data: {
                books: @json($books),
                users: @json($users),
                reserves: @json($reserves),
                isSuccess: false,
                statusMessage: ''
            },
            methods: {
                issuanceBook(reserve, book, user) {
                    this.showLoader();
                    axios.post(`/books/reserve`, {reserve: reserve, book: book, user: user})
                        .then(response => {
                            this.hideLoader();
                            this.showAlert('Книга была успешно выдана ученику', true);

                            this.books = this.books.filter(b => b.id !== book);
                        })
                        .catch(error => {
                            this.hideLoader();
                            this.showAlert('Произошла ошибка в выдаче книги', false);
                        });
                },
                deleteReservation(reserve, book)
                {
                    this.showLoader();
                    axios.delete(`/books/reserve/${reserve}`)
                        .then(response => {
                            this.hideLoader();
                            this.showAlert('Резервация была успешно удалена', true);

                            this.books = this.books.filter(b => b.id !== book);
                        })
                        .catch(error => {
                            this.hideLoader();
                            this.showAlert('Произошла ошибка в удалении резервации', false);
                        });
                },
                showAlert(message, bool) {
                    this.statusMessage = message;
                    this.isSuccess = bool;

                    setTimeout(() => {
                        this.statusMessage = '';
                        this.isSuccess = false;
                    }, 4000);
                },
                showLoader() {
                    document.getElementById('loader').style.display = 'block';
                },
                hideLoader() {
                    document.getElementById('loader').style.display = 'none';
                },
            }
        });
    </script>
@endsection
