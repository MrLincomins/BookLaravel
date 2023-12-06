@extends('layout.layout')

@section('content')
    <body>
    <section class="table-components" id="app">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>История изменений</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <p class="text-sm mb-20">
                                Здесь содержатся все изменения в библиотеке за неделю
                            </p>
                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><h6>Время</h6></th>
                                        <th><h6>Пользователь</h6></th>
                                        <th><h6>Событие</h6></th>
                                        <th><h6>Объект</h6></th>
                                        <th><h6>Изменения:</h6></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td class="min-width">
                                                <p><a>{{ $log->created_at }}</a></p>
                                            </td>
                                            <td class="min-width">
                                                <p><a>{{ $log->user->name ?? 'Неизвестный пользователь'  }}</a></p>
                                            </td>
                                            <td class="min-width">
                                                <p><a>{{ $log->action }}</a></p>
                                            </td>
                                            <td class="min-width">
                                                <p>{{ $log->entity_type }}</p>
                                            </td>
                                            <td class="min-width">
                                                <button type="button"
                                                        data-toggle="modal" data-target="#seeModal{{ $log->id }}"
                                                        class="text-danger">
                                                    <p>Просмотр изменений</p>
                                                </button>
                                            </td>
                                        </tr>
                                        <div class="modal fade" tabindex="-1" id="seeModal{{ $log->id }}"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Просмотр изменений</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $log->changes_entity }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
@endsection
