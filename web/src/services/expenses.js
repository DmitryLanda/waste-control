import api from "./api";
import Notifications from "./notifications";

export default {
    async addExpense(expense) {
        try {
            await api.post('/expenses', expense)

            return true
        } catch (e) {
            const resp = e.response.data
            switch (e.response.status) {
                case 400:
                    Notifications.error(resp.message, 'Неверный запрос')
                    break
                case 401:
                    Notifications.error(resp.message, 'Ошибка доступа')
                    break
                case 403:
                    Notifications.error(resp.message, 'Ошибка доступа')
                    break
                case 422:
                    let message = resp.message
                    let title = 'Ошибка'
                    if (resp.errors) {
                        message = Object.values(resp.errors).reduce((_, e) => _ += e.join(';'), '')
                        title = resp.message
                    }

                    Notifications.error(message, title)
                    break
                case 500:
                    Notifications.error('Сервер недоступен или не отвечает', 'Сервер недоступен')
                    break
            }

            return false
        }
    }
}