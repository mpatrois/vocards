export default {
  state: {
    currentSong: null,
    songs: [],
    urlPagePlaying: null,
    index: null,
  },
  mutations: {
    changeSong(state, { index, song, songs }) {
      state.index = index;
      state.songs = songs;
      state.currentSong = song;
    },
    changeUrlPagePlaying(state, urlPagePlaying) {
      state.urlPagePlaying = urlPagePlaying;
    },
    updateSongsList(state, songs) {
      state.songs = songs;
    },
  },
};

