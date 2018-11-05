<template>
    <div>
        <div class="text-center">
            <i class="info-upload">Pour ajouter vos musiques dans l'application</i>
            <button class="btn btn-primary add-song" id="show-modal" @click="showModal = true">
                Cliquez ici
                <input type="file" ref="songFile"
                  @change="uploadSongs" multiple/>
            </button>
            <div v-if="uploading">
              <h2 class="uploading">
                Upload en cours
              </h2>
              <div class="progress">
                <div class="progress-bar" role="progressbar"
                    :style="{width: percentCompleted+'%' }">
                </div>
              </div>
            </div>
        </div>
    </div>
</template>

<script>
import SongService from '../../services/song.services';

export default {
  props: ['loadSongsList'],
  data() {
    return {
      showModal: false,
      percentCompleted: 0,
      uploading: false,
    };
  },
  methods: {
    uploadSongs() {
      const { files } = this.$refs.songFile;
      const data = new FormData();

      for (let i = 0; i < files.length; i += 1) {
        data.append('songs[]', files[i]);
      }

      const config = {
        onUploadProgress: (progressEvent) => {
          this.percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        },
      };

      this.uploading = true;
      SongService.storeSong(data, config).then(() => {
        this.showModal = false;
        this.uploading = false;
        this.percentCompleted = 0;
        this.loadSongsList();
      });
    },
  },
};
</script>

<style lang="scss" scoped="true">
.info-upload{
  font-size: 20px;
  vertical-align: middle;
  margin-right: 20px;
  display: inline-block;
}
.uploading{
  margin-top:100px;
}
.add-song{
    position: relative;
    vertical-align: middle;
    input[type=file]{
      opacity: 0;
      position: absolute;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
    }
}
</style>
