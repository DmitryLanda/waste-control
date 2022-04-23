import './App.css';
import {Card, Col, Layout, Row} from 'antd';
import AccountList from "../Account";
import InputTransaction from "../InputTransaction";
import {DemoPlot, OverallStats, TopCategories} from "../Stats";
import TransactionList from "../Transaction";
import {Component} from "react";
import axios from "axios";

const {Header, Footer, Content} = Layout;

export default class App extends Component {
    constructor(props) {
        super(props)
        this.state = {
            userId: "30893c76-5ead-44d1-9b85-dcaa15fde08a",
            accounts: [],
            accountsLoading: false,
        }
    }

    async componentDidMount() {
        await this.fetchUserAccounts(this.state.userId)
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
                                <Card size="small" title="Топ категории" bordered={false} loading={accountsLoading}>
                                    <TopCategories account={account}/>
                                </Card>
                            </Col>
                            <Col span={4}>
                                <Card size="small" title="Расходы" bordered={false} loading={accountsLoading}>
                                    <OverallStats account={account}/>
                                </Card>
                            </Col>
                            <Col span={8}>
                                <Card size="small" title="Последние операции" bordered={false}
                                      loading={accountsLoading}>
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
