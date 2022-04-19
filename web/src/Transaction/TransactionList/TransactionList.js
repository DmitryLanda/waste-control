import './TransactionList.css'
import axios from 'axios'
import {Component} from "react"
import {Empty} from 'antd';
import TransactionItem from "../TransactionItem/Transactiontem";

export default class TransactionList extends Component {
    constructor(props) {
        super(props)
        this.state = {
            transactions: [],
            error: null,
            loading: false,
        }
    }

    async componentDidMount() {
        const {account: {id}, page = 1, limit = 4} = this.props
        await this.fetchTransactions(id, page, limit)
    }

    async fetchTransactions(accountId, page, limit) {
        try {
            this.setState({loading: true})
            const result = await axios(`http://localhost:81/accounts/${accountId}/transactions?page=${page}&limit=${limit}`)
            this.setState({transactions: result.data})
            this.setState({loading: false})
        } catch (e) {
            this.setState({error: e?.response?.data?.message})
        }
    }

    renderTransactions(transactions) {
        return (
            <div className="TransactionList">
                {transactions.map((transaction, i) => (
                    <TransactionItem transaction={transaction} key={i}/>
                ))}
            </div>
        )
    }

    renderNoData() {
        return <Empty/>
    }

    render() {
        const {transactions} = this.state

        if (transactions) {
            return this.renderTransactions(transactions)
        }

        return this.renderNoData()
    }
}