import './TransactionItem.css'
import {format, parseISO} from 'date-fns'
import {ru} from 'date-fns/locale'
import {Tag} from "antd";

import {Money} from '../../Shared'

export default function TransactionItem(props) {
    const {transaction} = props
    const timestamp = parseISO(transaction.timestamp)
    return (
        <div className="TransactionItem">
            <div className="additional-row">
                <span className="timestamp"> {format(timestamp, 'dd MMMM HH:mm', {locale: ru})}</span>
            </div>
            <div className="main-row">
                <Money size="small" amount={transaction.amount}/>
                <span className="title"> {transaction.comment}</span>
                <div className="tags">
                    {transaction.tags.map((tag, i) => (
                        <Tag key={i}>{tag}</Tag>
                    ))}
                </div>
            </div>
        </div>
    )
}