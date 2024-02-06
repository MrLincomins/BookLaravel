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
                                            <div class="d-flex align-items-center">
                                                <button type="button"
                                                        class="main-btn btn-sm primary-btn btn-hover text-center text-white"
                                                        @click="issuanceBook(reserves[index].id, book.id, users[index].id)">
                                                    Выдача книги пользователю
                                                </button>
                                                <div class="action ml-2">
                                                    <button @click="deleteReservation(reserves[index].id, book.id)"
                                                            type="button"
                                                            class="text-danger">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>
                                                </div>
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
            <div class="toasts">
                <div v-for="(toast, index) in toasts" :key="index" class="toast-notification"
                     :class="'toast-' + (index + 1) + ' toast-notification ' + toast.animation">
                    <div class="toast-content">
                        <div class="toast-icon" :style="{ 'background-color': toast.iconColor }">
                            <i class="fas" :class="toast.icon"></i>
                        </div>
                        <div class="toast-msg">@{{ toast.message }}</div>
                    </div>
                    <div class="toast-progress">
                        <div class="toast-progress-bar" :style="{ width: '100%' }"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>

    <script>
        const app = new Vue({
            el: '.table-components',
            data: {
                books: @json($books),
                users: @json($users),
                reserves: @json($reserves),
                toasts: []
            },
            methods: {
                issuanceBook(reserve, book, user) {
                    this.showLoader();
                    axios.post(`/books/reserve`, {reserve: reserve, book: book, user: user})
                        .then(response => {
                            if (response.data.status) {
                                this.showToast(response.data.status, response.data.message)
                            } else if (response.data.redirect) {
                                this.books = this.books.filter(b => b.id !== book);
                                this.showToast('success', 'Книга успешно выдана ученику')
                            } else {
                                this.showToast('error', 'Неизвестная ошибка при резервации')
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Неизвестная ошибка при возврате книги')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                deleteReservation(reserve, book) {
                    this.showLoader();
                    axios.delete(`/books/reserve/${reserve}`)
                        .then(response => {
                            this.showToast(response.data.status, response.data.message)
                            if (response.data.status === 'success') {
                                this.books = this.books.filter(b => b.id !== book);
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Неизвестная ошибка при возврате книги')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                }
                ,
            }
        });
    </script>
@endsection
