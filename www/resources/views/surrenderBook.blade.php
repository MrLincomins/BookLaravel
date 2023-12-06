@extends('layout.layout')

@section('content')

<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title d-flex align-items-center flex-wrap mb-30">
                    <h2 class="mr-40">Выдача книги ученику</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/books">books</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                surrender
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
                                <h1>{{ $book->tittle }}</h1>
                                <p class="text">
                                    <span class="text-medium">Автор:</span>
                                    {{ $book->author }}
                                </p>
                                <p class="text">
                                    <span class="text-medium">Жанр:</span>
                                    {{ $book->genre }}
                                </p>
                                <p class="text">
                                    <span class="text-medium">Год:</span>
                                    {{ $book->year }}
                                </p>
                            </div>
                            <div class="invoice-for">
                            </div>
                            <div class="logo col-14">
                                <img src="{{ $book->picture }}" alt=""/>
                            </div>
                        </div>
                        <div class="form-elements-wrapper">
                            <div class="col-lg-9" style="margin-top: 10%;">
                                <div class="card-style">
                                    <h6 class="mb-25">Введите id ученика</h6>
                                    <div class="input-style-1">
                                        <input form="id" type="text" name='iduser' placeholder="idUser"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-action">
                        <ul class="d-flex flex-wrap align-items-center justify-content-center">
                            <li class="m-2">
                                <a href="/books" class="main-btn primary-btn-outline btn-hover">
                                    Отмена
                                </a>
                            </li>
                            <li class="m-2">
                                <form method="post" id="id" action="/books/surrender/{{ $book->id }}">
                                    @csrf
                                    <button class="main-btn primary-btn btn-hover" type="submit">
                                        Выдать
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

@endsection
