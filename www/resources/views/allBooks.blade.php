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
                            <h2>Книги</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <p class="text-sm mb-20">
                                Тут находятся все книги, которые не взяли и могут быть взяты в будущем
                            </p>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><h6>Название</h6></th>
                                        <th><h6>Автор</h6></th>
                                        <th><h6>Кол-во</h6></th>
                                        <th><h6>Год</h6></th>
                                        <th><h6>Жанр</h6></th>
                                        <th><h6>ISBN</h6></th>
                                        <th>
                                            <h6 class="text-sm text-medium text-end">
                                                Управление <i class="lni lni-arrows-vertical"></i>
                                            </h6>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="book in books" :key="book.id">
                                        <td class="min-width">
                                            <div class="lead">
                                                <div class="lead-image bgc-img">
                                                    <img :src="book.picture" alt="" class="lup"/>
                                                </div>
                                                <div class="lead-text">
                                                    <p>@{{ book.tittle }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="min-width">
                                            <p><a>@{{ book.author }}</a></p>
                                        </td>
                                        <td class="min-width">
                                            <p><a>@{{ book.count }}</a></p>
                                        </td>
                                        <td class="min-width">
                                            <p>@{{ book.year }}</p>
                                        </td>
                                        <td class="min-width">
                                            <p>@{{ book.genre }}</p>
                                        </td>
                                        <td class="min-width">
                                            <p>@{{ book.isbn }}</p>
                                        </td>
                                        <td>
                                            <div class="action justify-content-end">
                                                <form method="get" :action="'books/edit/' + book.id">
                                                    <button class="text-secondary" type="submit">
                                                        <i class="mdi mdi-tools"></i>
                                                    </button>
                                                </form>
                                                <button @click="deleteBook(book.id)" class="text-danger">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>

                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a :href="'books/reserve/' + book.id" class="text-gray">Резервация</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a :href="'books/surrender/' + book.id" class="text-gray">Выдача
                                                            книг</a>
                                                    </li>
                                                </ul>
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

    <script>
        new Vue({
            el: '#app',
            data: {
                books: @json($books),
            },
            methods: {
                deleteBook(bookId) {
                    if (confirm('Вы уверены, что хотите удалить книгу?')) {
                        this.showLoader();
                        axios.delete(`/books/${bookId}`)
                            .then(response => {
                                if (response.data.status) {
                                    // Удалите книгу из списка books
                                    this.books = this.books.filter(book => book.id !== bookId);
                                } else {
                                    alert('Ошибка при удалении книги');
                                }
                            })
                            .finally(() => {
                                this.hideLoader();
                            });
                    }
                },
                showLoader() {
                    document.getElementById('loader').style.display = 'block';
                },
                hideLoader() {
                    document.getElementById('loader').style.display = 'none';
                }
            },
        });
    </script>
    </body>
@endsection

