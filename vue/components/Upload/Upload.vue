<template>
    <div class="grid text-center">
        <h1>
            Uploader des musiques
        </h1>
        <div>
            <UploadSongsModal :loadSongsList="loadSongsList"/>
        </div>
        <div>
          <i class="info-validate">
            Maintenant valider les informations concernant vos titres
          </i>
        </div>
        <h3>Liste des sons</h3>
        <ul>
            <ApproveSongMeta v-for="song in songs"
            :key="song.id"
            :song="song"
            :removeSongFromList="removeSongFromList" />
        </ul>
    </div>

</template>

<script>
import ApproveSongMeta from './ApproveSongMeta';
import UploadSongsModal from './UploadSongsModal';
import SongService from '../../services/song.services';

export default {
  components: { UploadSongsModal, ApproveSongMeta },
  data() {
    return {
      songs: [],
    };
  },
  created() {
    this.loadSongsList();
  },
  methods: {
    removeSongFromList(id) {
      this.songs = this.songs.filter(song => song.id !== id);
    },
    loadSongsList() {
      SongService.getSongsToValidate().then((response) => {
        this.songs = response.data;
      });
    },
  },
};
</script>

<style lang="scss">
i.info-validate{
    font-size: 20px;
    vertical-align: middle;
    margin-right: 20px;
    display: inline-block;
}
</style>
