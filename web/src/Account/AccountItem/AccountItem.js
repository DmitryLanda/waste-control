import './AccountItem.css'
import { Money } from '../../Shared'

export default function AccountItem(props) {
    const { account } = props

    return (
        <div className="AccountItem">
            <strong>{account.name || account.id}</strong>: <Money amount={account.total} />
        </div>
    )
}