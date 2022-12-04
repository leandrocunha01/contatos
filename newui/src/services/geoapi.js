// key=AIzaSyAUp_PkomjqmdHEFyP7WupIcAFy2y9xotY&address=Rua João Zaleski

import axios from 'axios'

const geoApi = axios.create({
    baseURL: 'https://maps.googleapis.com/maps/api/geocode',
    timeout: 30000,
    params: {
        key: 'AIzaSyAUp_PkomjqmdHEFyP7WupIcAFy2y9xotY'
    }
});

export default geoApi
