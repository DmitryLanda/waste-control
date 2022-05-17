import './InputTransaction.css'
import {Input, notification} from 'antd';
import {useEffect, useState} from "react";
import axios from "axios";

function parseInput(string) {
    const {0: title, 1: amount, ...remaining} = string.split(',').map(v => v.trim())
    const tags = Object.values(remaining).filter(v => v.length)

    return {title, amount, tags}
}

function validateData(input) {
    const errors = []
    if (!input.title) {
        errors.push('Название обязательно')
    }

    if (!input.amount) {
        errors.push('Сумма обязательна')
    }
    if (!/^-?[0-9]+(\.[0-9]+)?$/.test(input.amount)) {
        errors.push('Неверная сумма')
    }

    return errors
}

export default function InputTransaction(props) {
    const {accountId} = props
    const [status, setStatus] = useState(null)
    const [loading, setLoading] = useState(false)

    async function submitTransaction(event) {
        event.preventDefault();

        setStatus(null)

        const input = parseInput(event.target.value)
        const errors = validateData(input)
        if (errors.length) {
            setStatus('error')
            notification.error({
                message: 'Невозможно добавить транзакцию',
                description: (errors.map(error => <div>{error}</div>))
            });

            return
        }

        try {
            setLoading(true)
            await axios.post(
                `http://localhost:81/accounts/${accountId}/transactions`,
                {amount: Number.parseFloat(input.amount), comment: input.title, tags: input.tags}
            )
            setLoading(false)
            setStatus(null)
        } catch (e) {
            setLoading(false)
            console.log(e?.response?.data)
        }
    }

    return (
        <div className="InputTransaction">
            <Input
                className="Input"
                placeholder="Бургеры, -1400, 25 марта, доставка, еда"
                status={status}
                // loading="loading"
                onPressEnter={submitTransaction}
            />
        </div>
    );
}