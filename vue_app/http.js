import axios from 'axios';
import {config} from './config'

export const http = axios.create({
    baseURL: config.baseUrl,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'x-xsrf-token': document.getElementsByName('csrf-token')[0].getAttribute('content')
    },
})