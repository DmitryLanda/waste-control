import './Money.css'

export default function Money(props) {
    const { amount } = props
    const isPositive = amount >= 0
    const cssClasses = ['Money']

    if (isPositive) {
        cssClasses.push('Positive')
    } else {
        cssClasses.push('Negative')
    }

    return (
        <span className={cssClasses.join(' ')}>{amount}</span>
    )
}