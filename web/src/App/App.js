import './App.css';
import {Card, Col, Layout, Row} from 'antd';
import AccountList from "../Account";
import InputTransaction from "../InputTransaction";
import {DemoPlot} from "../Stats";
import {Money} from "../Shared";
import TransactionList from "../Transaction";
import {Component} from "react";
import axios from "axios";

const {Header, Footer, Content} = Layout;

export default class App extends Component {
    constructor(props) {
        super(props)
        this.state = {
            userId: "30893c76-5ead-44d1-9b85-dcaa15fde08a",
            user: null,
            accounts: [],
            userLoading: false,
            accountsLoading: false,
            transactionsLoading: false,
        }
    }

    async componentDidMount() {
        await this.fetchUserInfo(this.state.userId)
        await this.fetchUserAccounts(this.state.userId)
    }

    async fetchUserInfo(userId) {
        try {
            this.setState({userLoading: true})
            const result = await axios(`http://localhost:81/users/${userId}`)
            this.setState({user: result.data})
            this.setState({userLoading: false})
        } catch (e) {
            console.log(e?.response?.data?.message)
        }
    }

    async fetchUserAccounts(userId) {
        try {
            this.setState({accountsLoading: true})
            const result = await axios(`http://localhost:81/users/${userId}/accounts`)
            this.setState({accounts: result.data})
            this.setState({accountsLoading: false})
        } catch (e) {
            console.log(e?.response?.data?.message)
        }
    }

    render() {
        const {accounts, accountsLoading} = this.state
        const account = accounts[0] || null

        return (
            <div className="App">
                <Layout>
                    <Header>
                        <InputTransaction/>
                    </Header>
                    <Content>
                        <Row gutter={8}>
                            <Col span={8}>
                                <Card size="small"
                                      title="Мои счета"
                                      loading={accountsLoading}>
                                    <AccountList accounts={accounts}/>
                                </Card>
                            </Col>
                            <Col span={4}>
                                <Card size="small" title="Топ категории">
                                    <div>Заказ еды</div>
                                    <div>Ресторан</div>
                                    <div>Бензин</div>
                                    <div>Путешествия</div>
                                    <div>Кредиты</div>
                                </Card>
                            </Col>
                            <Col span={4}>
                                <Card size="small" title="Расходы">
                                    <Row>
                                        <Col span={12}>Сегодня:</Col>
                                        <Col span={12}><Money amount={-1234.0}/></Col>

                                        <Col span={12}>Неделя:</Col>
                                        <Col span={12}><Money amount={-20789.5}/></Col>

                                        <Col span={12}>Месяц:</Col>
                                        <Col span={12}><Money amount={-152789.5}/></Col>
                                    </Row>
                                </Card>
                            </Col>
                            <Col span={8}>
                                <Card size="small" title="Последние операции" bordered={false} loading={accountsLoading}>
                                    <TransactionList account={account}/>
                                </Card>
                            </Col>
                        </Row>
                        <Row gutter={[8, 8]} style={{marginTop: '2vmin'}}>
                            <Col span={24}>
                                <Card size="small" className="card-chart">
                                    <DemoPlot/>
                                </Card>
                            </Col>
                        </Row>
                    </Content>
                    <Footer></Footer>
                </Layout>
            </div>
        );
    }
}
