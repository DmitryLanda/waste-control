import moment from "./moment";
import api from "./api";

const categories = (limit = 5) => {
    const list = [
        'Кино',
        'Бар',
        'Авто',
        'Проезд',
        'Кафе',
        'Одежда',
        'Продукты',
    ]
    list.sort(() => (Math.random() > .5) ? 1 : -1);

    const obj = {}
    list.slice(0, limit).forEach((category) => obj[category] = Math.ceil(Math.random() * 1000))

    return obj
}

export default {
    async expensesForToday() {
        try {
            const { data } = await api.get('/stats/today')
            console.log(data)

            return {
                title: moment(data.end).format('D MMMM'),
                values: data.expenses
            }
        } catch (e) {
            //
        }
    },
    async expensesForWeek() {
        try {
            const { data } = await api.get('/stats/week')

            const monday = moment(data.start).format('D')
            const saturday = moment(data.end).format('D MMMM')

            return {
                title: `${monday} - ${saturday}`,
                values: data.expenses
            }
        } catch (e) {
            //
        }
    },
    async expensesForMonth() {
        try {
            const { data } = await api.get('/stats/month')

            return {
                title: moment(data.end).format('MMMM'),
                values: data.expenses
            }
        } catch (e) {
            //
        }
    }
}