const showToast = {
    showToast(type, message) {
        let icon, iconColor;

        switch (type) {
            case 'success':
                icon = 'mdi mdi-check';
                iconColor = '#27ae60';
                break;
            case 'error':
                icon = 'mdi mdi-exclamation';
                iconColor = '#c0392b';
                break;
            case 'info':
                icon = 'mdi mdi-information-variant';
                iconColor = '#2980b9';
                break;
            case 'warning':
                icon = 'mdi mdi-alert-outline';
                iconColor = '#f39c12';
                break;
            default:
                icon = 'mdi mdi-help';
                iconColor = '#ffffff';
                break;
        }

        this.toasts.push({
            message,
            icon: icon,
            iconColor,
            animation : 'slide-in-slide-out'
        });
        setTimeout(() => {
            this.toasts.shift();
        }, 3800);
    }
};

Vue.mixin({
    methods: showToast
});
