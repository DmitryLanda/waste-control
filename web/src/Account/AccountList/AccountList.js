import './AccountList.css'
import AccountItem from "../AccountItem/AccountItem";

export default function AccountList(props) {
    const {accounts} = props

    return (
        <div className="AccountList">
            {accounts.map((account, i) => (
                <AccountItem account={account} key={i}/>
            ))}
        </div>
    )
}