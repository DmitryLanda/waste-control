import './InputTransaction.css'
import { Input } from 'antd';

export default function InputTransaction() {
    return (
        <div className="InputTransaction">
            <Input className="Input" placeholder="Бургеры, -1400, 25 марта, доставка, еда" />
        </div>
    );
}