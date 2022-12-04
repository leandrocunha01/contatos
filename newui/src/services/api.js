import axios from 'axios'

const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    timeout: 30000,
    params: {}
});

api.interceptors.request.use(function (config) {
    config.headers['Authorization'] = `Bearer ${ localStorage.getItem("accessToken") }`
    return config
}, function (error) {
    return Promise.reject(error)
});

export default api
