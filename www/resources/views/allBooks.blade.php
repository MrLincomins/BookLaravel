@extends('layout.layout')
@php
    use App\Services\PermissionService;
    $permission = new PermissionService();
@endphp
@section('content')
    <body>
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
                                <table class="table table-fixed">
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
                                    <tr v-for="book in paginatedBooks" :key="book.id">
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
                                                @if($permission->hasPermission(1))
                                                    <form method="get" :action="'books/edit/' + book.id">
                                                        <button class="text-secondary" type="submit">
                                                            <i class="mdi mdi-tools"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($permission->hasPermission(2) )
                                                    <button @click="confirmDelete(book.id, book.tittle)" type="button"
                                                            data-toggle="modal" data-target="#deleteModal"
                                                            class="text-danger">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>
                                                @endif

                                                <button class="more-btn ml-10 dropdown-toggle" id="moreAction1"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="lni lni-more-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="moreAction1">
                                                    <li class="dropdown-item">
                                                        <a :href="'books/reserve/' + book.id" class="text-gray">Резервация</a>
                                                    </li>
                                                    @if($permission->hasPermission(8))
                                                        <li class="dropdown-item">
                                                            <a :href="'books/surrender/' + book.id" class="text-gray">Выдача
                                                                книги</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav v-if="shouldShowPagination">
                                <ul class="pagination">
                                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                        <a class="page-link" @click="prevPage"><<</a>
                                    </li>
                                    <li class="page-item" v-for="page in totalPages" :key="page"
                                        :class="{ active: currentPage === page }">
                                        <a class="page-link" @click="changePage(page)">@{{ page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                        <a class="page-link" @click="nextPage">>></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="deleteModal" v-if="showDeleteModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Удаление</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    @click="showDeleteModal = false">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Вы точно хотите удалить книгу "@{{ bookToDelete.title }}"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    @click="showDeleteModal = false">Нет
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="deleteBook">Да
                            </button>
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
    </section>
    </body>
    <script src="/resources/js/loader.js"></script>
    <script src="/resources/js/toast.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                books: @json($books),
                showDeleteModal: false,
                bookToDelete: {id: null, title: ''},
                itemsPerPage: 6,
                currentPage: 1,
                toasts: []

            },
            computed: {
                totalPages() {
                    return Math.ceil(this.books.length / this.itemsPerPage);
                },
                paginatedBooks() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.books.slice(start, end);
                },
                shouldShowPagination() {
                    return this.totalPages > 1;
                },
            },
            methods: {
                deleteBook() {
                    this.showDeleteModal = false;
                    this.showLoader();
                    axios.delete(`/books/${this.bookToDelete.id}`)
                        .then(response => {
                            if (response.data.status) {
                                this.books = this.books.filter(book => book.id !== this.bookToDelete.id);
                                this.showToast('success', 'Книга удалена')
                            } else {
                                this.showToast('error', 'Ошибка удалении книги!')
                            }
                        })
                        .catch(error => {
                            this.showToast('error', 'Ошибка удалении книги!')
                        })
                        .finally(() => {
                            this.hideLoader();
                        });
                },
                confirmDelete(id, title) {
                    this.bookToDelete.id = id;
                    this.bookToDelete.title = title;
                    this.showDeleteModal = true;
                },
                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },
                changePage(page) {
                    this.currentPage = page;
                },
            },
        });
    </script>
    <style>
        .table-wrapper table {
            width: 100%;
            min-height: 450px;
        }
    </style>
@endsection
