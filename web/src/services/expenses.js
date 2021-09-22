import moment from "moment";

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
        return await (new Promise((resolve, reject) => {
            setTimeout(() => resolve({
                title: moment().format('D MMMM'),
                values: categories(3)
            }), 1000)
        }));
    },
    expensesForWeek() {
        const monday = moment().startOf('week').format('D')
        const saturday = moment().endOf('week').format('D MMMM')

        return {
            title: `${monday} - ${saturday}`,
            values: categories(7)
        }
    },
    expensesForMonth() {
        return {
            title: moment().format('MMMM'),
            values: categories(10)
        }
    }
}