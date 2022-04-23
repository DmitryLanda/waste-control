import './StatsItem.css'
import {Row, Col} from 'antd';
import {Money} from "../../../Shared";

export default function StatsItem(props) {
    const {title, stats} = props
    return stats && (
        <Row>
            <Col span={12}>{title}:</Col>
            <Col span={12}><Money amount={-stats.spends}/></Col>
        </Row>
    )
}