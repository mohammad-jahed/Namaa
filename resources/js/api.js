// resources/js/api.js

import axios from 'axios';

const baseURL = 'http://127.0.0.1:8000/api';

const axiosInstance = axios.create({
    baseURL,
    withCredentials: true,
});

axiosInstance.interceptors.request.use(config => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    config.headers['X-XSRF-TOKEN'] = csrfToken;

    const authToken = localStorage.getItem('authToken');
    if (authToken) {
        config.headers.Authorization = `Bearer ${authToken}`;
    }

    return config;
});

export default {
    get(endpoint) {
        return axiosInstance.get(endpoint);
    },

    post(endpoint, data) {
        return axiosInstance.post(endpoint, data);
    },

    put(endpoint, data) {
        return axiosInstance.put(endpoint, data);
    },

    delete(endpoint) {
        return axiosInstance.delete(endpoint);
    },


};
