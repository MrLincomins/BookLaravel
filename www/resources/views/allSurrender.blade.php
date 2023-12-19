@extends('layout.layout')

@section('content')
    <div id="loader" class="loader"></div>
    <section class="table-components" id="app">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Книги взятые из библиотеки</h2>
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
                            <h6 class="mb-10">Взятые книги</h6>
                            <p class="text-sm mb-20">
                                Все книги, взятые учениками, находятся тут
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
                                            <p>@{{ surrenders[index].date }}</p>
                                        </td>
                                        <td>
                                            <button type="button" class="text-danger"
                                                    @click="returnBook(surrenders[index].id, book.id)">
                                                <p>Возврат в библиотеку</p>
                                            </button>
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

    <script>
        const app = new Vue({
            el: '.table-components',
            data: {
                books: @json($books),
                users: @json($users),
                surrenders: @json($surrenders),
                isSuccess: false,
                statusMessage: ''
            },
            methods: {
                returnBook(issuance, book) {
                    this.showLoader();
                    axios.post(`/books/surrender`, {issuance: issuance, book: book})
                        .then(response => {
                            this.hideLoader();
                            this.showAlert('Книга успешно была возвращена в библиотеку', true);

                            this.books = this.books.filter(b => b.id !== book);
                        })
                        .catch(error => {
                            this.hideLoader();
                            this.showAlert('Произошла ошибка в удалении книги', false);
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

