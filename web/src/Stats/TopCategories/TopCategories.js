import {Empty} from 'antd';
import {Component} from "react";
import axios from "axios";
import CategoryItem from "./CategoryItem/CategoryItem";

export default class TopCategories extends Component {
    constructor(props) {
        super(props)
        this.state = {
            categories: [],
            loading: false,
        }
    }

    async componentDidMount() {
        const {account: {id}, limit = 8} = this.props
        await this.fetchCategories(id, limit)
    }

    async fetchCategories(accountId, limit) {
        try {
            this.setState({loading: true})
            const result = await axios(`http://localhost:81/accounts/${accountId}/statistic/categories?limit=${limit}`)
            this.setState({categories: result.data})
            this.setState({loading: false})
        } catch (e) {
            this.setState({error: e?.response?.data?.message})
        }
    }


    render() {
        const {categories} = this.state

        if (categories) {
            return (
                <div className="TransactionList">
                    {categories.map((category, i) => (
                        <CategoryItem category={category} key={i}/>
                    ))}
                </div>
            )
        }

        return <Empty/>
    }
}