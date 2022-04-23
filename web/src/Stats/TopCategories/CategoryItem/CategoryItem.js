export default function CategoryItem(props) {
    const {category} = props

    return category && (
        <div>{category.name}</div>
    )
}