import './OverallStats.css'
import {Row} from 'antd';
import {Component} from "react";
import axios from "axios";
import StatsItem from "./StatsItem/StatsItem";

export default class OverallStats extends Component {
    constructor(props) {
        super(props)
        this.state = {
            day: null,
            week: null,
            month: null,
            year: null,
            loading: false,
        }
    }

    async componentDidMount() {
        const {account: {id}} = this.props
        await this.fetchStats(id)
    }

    async fetchStats(accountId) {
        try {
            this.setState({loading: true})
            const result = await axios(`http://localhost:81/accounts/${accountId}/statistic`)
            result.data.forEach((row) => {
                this.setState({[row.type]: row})
                console.log({[row.type]: row})
            })
            this.setState({loading: false})
        } catch (e) {
            this.setState({error: e?.response?.data?.message})
        }
    }

    render() {
        const {day, week, month, year, loading} = this.state
        return !loading && (
            <Row className="OverallStats">
                <StatsItem title="День" stats={day} />
                <StatsItem title="Неделя" stats={week} />
                <StatsItem title="Месяц" stats={month} />
                <StatsItem title="Год" stats={year} />
            </Row>
        )
    }
}