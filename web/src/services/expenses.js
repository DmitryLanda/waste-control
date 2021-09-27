import api from "./api";
import Notifications from "./notifications";

export default {
    async addExpense(expense) {
        try {
            await api.post('/expenses', {
                category: expense.category,
                value: expense.amount,
                date: expense.date.format('YYYY-MM-DD')
            })

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
                    Notifications.error(
                        Object.values(resp.errors).reduce((_, e) => _ += e.join(';'), ''),
                        resp.message
                    )
                    break
                case 500:
                    Notifications.error('Сервер недоступен или не отвечает', 'Сервер недоступен')
                    break
            }

            return false
        }
    }
}