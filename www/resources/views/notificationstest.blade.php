@extends('layout.layout')

@section('content')
<body class="app">
<section class="tab-components" id="app">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title mb-30">
                            <h2>test</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <form method="post" action="/notificationstest" class="w-40">
                    @csrf
                    <div class="card-style mb-3">
                        <div class="input-style-2">
                            <label>
                                <input type="text" name="event_name" placeholder="назв">
                            </label>
                            <label>
                                <input type="text" name="message" placeholder="месдж">
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="main-btn success-btn-outline square-btn btn-hover">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

