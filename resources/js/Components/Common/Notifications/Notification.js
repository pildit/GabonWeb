import Vue from 'vue';

class Notification {

    static general(title, text, type = 'info'){
        Vue.notify({
            group: "server",
            text: text,
            title: title,
            type: type
        });
    }

    static error (title, text) {
        this.general(title, text, 'error');
    }

    static success (title, text) {
        this.general(title, text, 'success');
    }
}
export default Notification;
