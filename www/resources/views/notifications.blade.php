@extends('layout.layout')

@section('content')
<body>
<div id="loader" class="loader"></div>
<div id="app" class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>Уведомления</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card-style">
        <div class="alert" :class="{ 'alert-success': isSuccess, 'alert-danger': !isSuccess }" v-if="statusMessage">
            @{{ statusMessage }}
        </div>
        <div v-for="notification in notifications" class="single-notification" :key="notification.id">
            <div class="notification">
                <div class="image primary-bg">
                    <span>Sys</span>
                </div>
                <a href="#0" class="content">
                    <h6>@{{ notification.event_name }} </h6>
                    <p class="text-sm text-gray">
                        @{{ notification.message }}
                    </p>
                    <span class="text-sm text-medium text-gray">@{{ calculateTimeAgo(notification.created_at) }}</span>
                </a>
            </div>
            <div class="action left">
                <button class="btn" @click="deleteNotification(notification.id)">
                    <i class="lni lni-trash-can"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="/resources/js/loader.js"></script>
<script src="/resources/js/showAlert.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            notifications: @json($notifications),
            statusMessage: '',
            isSuccess: false,
        },
        methods: {
            calculateTimeAgo(createdAt) {
                if (!createdAt) return '';

                const currentDate = new Date();
                const notificationDate = new Date(createdAt);
                const timeDifference = currentDate - notificationDate;
                const minutesDifference = Math.floor(timeDifference / 60000);

                if (minutesDifference < 60) {
                    return `${minutesDifference} минут назад`;
                } else {
                    const hoursDifference = Math.floor(minutesDifference / 60);
                    if (hoursDifference < 24) {
                        return `${hoursDifference} часов назад`;
                    } else {
                        const daysDifference = Math.floor(hoursDifference / 24);
                        return `${daysDifference} дней назад`;
                    }
                }
            },
            deleteNotification(notificationId) {
                this.showLoader();
                axios.delete(`/notifications/${notificationId}`)
                    .then(response => {
                        this.hideLoader();
                        if (response.data) {
                            this.showAlert('Уведомление успешно удалено', true)
                            this.notifications = this.notifications.filter(notification => notification.id !== notificationId);
                        } else {
                            this.showAlert('Ошибка в удалении уведомления', false)
                            console.error('Не удалось удалить уведомление');
                        }
                    })
                    .catch(error => {
                        this.hideLoader();
                        this.showAlert('Ошибка в удалении уведомления', false)
                        console.error('Произошла ошибка при удалении уведомления', error);
                    });
            },
        },
    });
</script>
</body>
@endsection

@include('layout.footer')
