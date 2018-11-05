import axios from 'axios';

const SongService = {
  getSongs() {
    return axios.get('/api/songs', {
      params: {
        valid: true,
      },
    });
  },
  getSongsToValidate() {
    return axios.get('/api/songs', {
      params: {
        valid: false,
      },
    });
  },
  storeSong(data, config) {
    return axios.post('/api/songs', data, config);
  },
  updateSong(song) {
    return axios.put(`/api/songs/${song.id}`, song);
  },
  deleteSong(id) {
    return axios.delete(`/api/songs/${id}`);
  },
};

export default SongService;
