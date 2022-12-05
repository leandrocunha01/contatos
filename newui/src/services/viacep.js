import axios from 'axios'

const viacep = axios.create({
    baseURL: 'https://viacep.com.br/ws/',
    timeout: 30000
});

export default viacep
