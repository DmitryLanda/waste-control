import {notification} from 'ant-design-vue';

notification.config({
    placement: 'bottomLeft',
    duration: 3,
});

export default {
    error(message, title = '') {
        return notification.error({
            message: title,
            description: message
        })
    },
    success(message, title = '') {
        return notification.success({
            message: title,
            description: message
        })
    }
}
