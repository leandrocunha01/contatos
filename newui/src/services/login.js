import axios from 'axios'

const login = axios.create({
    baseURL: 'http://localhost:8000/api',
    timeout: 30000
});

export default login
