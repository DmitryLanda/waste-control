import './AccountList.css'
import axios from 'axios'
import { Component } from "react"
import { Card } from 'antd';
import AccountItem from "../AccountItem/AccountItem";

export default class AccountList extends Component {
    constructor(props) {
        super(props)
        this.state = {
            accounts: [],
            error: null,
            loading: true,
        }
    }

    async componentDidMount() {
        await this.initUserInfo(this.props.userId)
    }

    async initUserInfo(userId) {
        try {
            const result = await axios(`http://localhost:81/users/${userId}/accounts`)
            this.setState({accounts: result.data})
            this.setState({loading: false})
        } catch (e) {
            this.setState({error: e?.response?.data?.message || 'User not found'})
        }
    }

    render() {
        const { accounts, error, loading } = this.state

        return (
            <div className="AccountList">
                <Card size="small" className="AccountCard" title="Мои счета" bordered={false} loading={loading}>
                    {accounts.map((account, i) => (
                        <AccountItem account={account} key={i} />
                    ))}
                </Card>
            </div>
        )
    }
}