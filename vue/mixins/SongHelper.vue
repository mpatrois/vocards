<script>
export default {
  data() {
    return {
      songOptionOpened: null,
    };
  },
  created() {
    document.addEventListener('click', () => {
      this.songOptionOpened = null;
      this.$bus.$emit('set-playlist-context-menu', null);
      this.$bus.$emit('set-callback-fn', null);
    });
  },
  computed: {
    currentSong() {
      return this.$store.state.playerModule.currentSong;
    },
    urlPagePlaying() {
      return this.$store.state.playerModule.urlPagePlaying;
    },
  },
  methods: {
    openCtxMenuSong(song) {
      this.$bus.$emit('open-song-menu', song);
      this.songOptionOpened = song;
    },
    getSongDuration(song) {
      const secNum = parseInt(song, 10);
      let hours = Math.floor(secNum / 3600);
      let minutes = Math.floor((secNum - (hours * 3600)) / 60);
      let seconds = secNum - (hours * 3600) - (minutes * 60);
      if (hours < 10) { hours = `0${hours}:`; }
      if (hours === '00:') { hours = ''; }
      if (minutes < 10) { minutes = `0${minutes}`; }
      if (seconds < 10) { seconds = `0${seconds}`; }
      return `${hours + minutes}:${seconds}`;
    },
  },
};
</script>
