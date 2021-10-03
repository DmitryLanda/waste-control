import moment from "./moment";
import api from "./api";

export default {
    async expensesForToday() {
        try {
            const { data } = await api.get('/stats/today')

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

            let monday = moment(data.start).format('D')
            let saturday = moment(data.end).format('D MMMM')

            //edge of month - we need to show names for both months
            if (moment(data.start).format('M') !== moment(data.end).format('M')) {
                monday = moment(data.start).format('D MMMM')
            }

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