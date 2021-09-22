import axios from 'axios'

export default axios.create({
    baseURL: 'http://localhost',
    timeout: 5000,
    headers: {
        'Content-Type': 'application/json'
    }
})