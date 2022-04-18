import './App.css';
import { Layout, Row, Col, Card } from 'antd';
import AccountList from "../Account";
import InputTransaction from "../InputTransaction";
import {DemoPlot} from "../Stats";
import {Money} from "../Shared";

const { Header, Footer, Content } = Layout;

export default function App() {
  return (
    <div className="App">
        <Layout>
            <Header>
                <InputTransaction />
            </Header>
            <Content>
                <Row gutter={8}>
                    <Col span={8}>
                        <AccountList userId="65220498-08b5-4531-9643-9aab3135f0c3" />
                    </Col>
                    <Col span={4}>
                        <Card size="small" title="Топ категории" style={{backgroundColor: '#242b51', marginBottom: '1vmin', height: '30vmin'}}>
                            <div>Заказ еды</div>
                            <div>Ресторан</div>
                            <div>Бензин</div>
                            <div>Путешествия</div>
                            <div>Кредиты</div>
                        </Card>
                    </Col>
                    <Col span={4}>
                        <Card size="small" title="Расходы" style={{backgroundColor: '#242b51', marginBottom: '1vmin', height: '30vmin'}}>
                            <Row>
                                <Col span={12}>Сегодня:</Col>
                                <Col span={12}><Money amount={-1234.0} /></Col>

                                <Col span={12}>Неделя:</Col>
                                <Col span={12}><Money amount={-20789.5} /></Col>

                                <Col span={12}>Месяц:</Col>
                                <Col span={12}><Money amount={-152789.5} /></Col>
                            </Row>
                        </Card>
                    </Col>
                    <Col span={8}>
                        <Card size="small" title="Последние операции" style={{backgroundColor: '#242b51', height: '30vmin'}}></Card>
                    </Col>
                </Row>
                <Row gutter={[8, 8]} style={{marginTop: '2vmin'}}>
                    <Col span={24}>
                        <Card size="small" style={{backgroundColor: '#242b51'}}>
                            <DemoPlot />
                        </Card>
                    </Col>
                </Row>
            </Content>
            <Footer></Footer>
        </Layout>
    </div>
  );
}
