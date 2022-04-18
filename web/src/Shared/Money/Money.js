import './Money.css'

export default function Money(props) {
    const { amount, size = 'normal' } = props
    const isPositive = amount >= 0
    const cssClasses = ['Money', size]

    if (isPositive) {
        cssClasses.push('Positive')
    } else {
        cssClasses.push('Negative')
    }

    return (
        <span className={cssClasses.join(' ')}>{amount}</span>
    )
}