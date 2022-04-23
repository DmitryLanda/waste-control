import './Money.css'

function shortify(value) {
    const digits = Math.floor(Math.log10(Math.abs(value)))
    console.log(value, digits)
    if (digits < 3) {
        return value
    }
    if (digits >= 3 && digits < 6) {
        return Math.round(value / 100) / 10.0 + 'K'
    }

    return Math.ceil(value / 100000) / 10.0 + 'M'
}

export default function Money(props) {
    const {amount, size = 'normal'} = props
    const isPositive = amount >= 0
    const cssClasses = ['Money', size]

    if (isPositive) {
        cssClasses.push('Positive')
    } else {
        cssClasses.push('Negative')
    }

    return (
        <span className={cssClasses.join(' ')}>{shortify(amount)}</span>
    )
}