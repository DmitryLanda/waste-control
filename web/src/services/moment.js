import moment from "moment";
import 'moment/locale/ru'

moment.locale('ru');

export default str => moment.utc(str)