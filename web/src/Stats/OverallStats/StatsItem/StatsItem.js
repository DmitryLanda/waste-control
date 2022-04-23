import './StatsItem.css'
import {Col} from 'antd';
import {Money} from "../../../Shared";

export default function StatsItem(props) {
    const {title, stats} = props
    return stats && (
        <>
            <Col span={8}>{title}:</Col>
            <Col span={16}><Money amount={-stats.spends}/></Col>
        </>
    )
}