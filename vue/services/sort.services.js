import axios from 'axios';

const SortService = {
  getSort(id) {
    return axios.get(`/api/sorts/${id}`);
  },
  getSorts() {
    return axios.get('/api/sorts');
  },
  storeSort(data) {
    return axios.post('/api/sorts', data);
  },
  updateSort(id, data) {
    return axios.put(`/api/sorts/${id}`, data);
  },
  deleteSort(id) {
    return axios.delete(`/api/sorts/${id}`);
  },
};

export default SortService;
