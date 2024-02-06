@extends('layout.layout')

@section('content')
    <body>
    <div id="loader" class="loader"></div>
    <section class="tab-components">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>Поиск по году</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-elements-wrapper">
                <div id="app">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-style mb-30">
                                <h6 class="mb-25">Введите год</h6>
                                <div class="input-style-1">
                                    <label>Год(ОТ)</label>
                                    <input v-model="firstYear" type="number" placeholder="0" autocomplete="off">
                                </div>
                                <div class="input-style-1">
                                    <label>Год(ДО)</label>
                                    <input v-model="secondYear" type="number" placeholder="9999" autocomplete="off">
                                </div>
                                <div class="col-12">
                                    <div class="button-group d-flex justify-content-center flex-wrap">
                                        <button @click="searchBooks" class="main-btn primary-btn btn-hover w-100 text-center">
                                            Искать
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card-style mb-30">
                                <h6 class="mb-10">Найденые данные:</h6>
                                <div class="table-wrapper table-responsive">
                                    <table class="table striped-table">
                                        <thead>
                                        <tr>
                                            <th><h6>Название</h6></th>
                                            <th><h6>Автор</h6></th>
                                            <th><h6>ISBN</h6></th>
                                            <th><h6>Жанр</h6></th>
                                            <th><h6>Год</h6></th>
                                            <th><h6>Кол-во на складе</h6></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="book in books">
                                            <td>@{{ book.tittle }}</td>
                                            <td>@{{ book.author }}</td>
                                            <td>@{{ book.isbn }}</td>
                                            <td>@{{ book.genre }}</td>
                                            <td>@{{ book.year }}</td>
                                            <td>@{{ book.count }}</td>
                                        </tr>
                                        <tr v-if="books.length === 0">
                                            <td colspan="6">Нет данных</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
    <script src="/resources/js/loader.js"></script>
    
    <script>
        new Vue({
            el: '#app',
            data: {
                firstYear: '',
                secondYear: '',
                books: []
            },
            methods: {
                searchBooks() {
                    this.showLoader();

                    axios.post('/books/year', { first: this.firstYear, second: this.secondYear })
                        .then(response => {
                            this.books = response.data;
                        })
                        .catch(error => {
                            console.error(error);
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
            }
        });
    </script>
@endsection

