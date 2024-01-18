import axios from 'axios';
import router from './../../router';

var getToken = () => {
    try {
        var toke = localStorage.getItem("token");
        if (!toke)
            return null;
        return JSON.parse(toke)
    } catch {
        return null;
    }
};

var errorHandler = (error) => {
    if (error.response.status === 403) {
        router.push('/unauthorized');
    }
    return Promise.reject(error);
}

axios.interceptors.request.use(async config => {
    config.baseURL = "http://127.0.0.1:8000"
    config.headers.Authorization = "Bearer " + getToken();
    config.headers.Accept = "application/json,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
    return config
}, errorHandler)

axios.interceptors.response.use(async (res) => {
    return res;
}, errorHandler);

export default axios;