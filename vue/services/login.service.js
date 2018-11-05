import axios from 'axios';

const LoginService = {
  user() {
    return axios.get('/api/user');
  },
  login(data) {
    return axios.post('/api/login', data);
  },
  logout() {
    return axios.get('/api/logout');
  },
};

export default LoginService;
