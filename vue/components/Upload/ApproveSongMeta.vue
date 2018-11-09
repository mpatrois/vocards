<template>
    <transition name="fade">
        <li class="song-informations">
            <div>
                <label>Titre</label>
                <input v-model="songToModify.title">
            </div>
            <div>
                <label>Description</label>
                <input v-model="songToModify.description">
            </div>
            <div class="text-left">
                <button class="preview" v-if="!preview" @click="preview=true">Aperçu</button>
                <audio v-if="preview" controls>
                    <source :src="urlPreview"/>
                </audio>
            </div>
            <div>
                <button class="btn btn-cancel" @click="deleteSong()">
                    Supprimer
                </button>
                <button class="btn btn-green" @click="validateMeta()">
                    Valider
                </button>
            </div>
        </li>
    </transition>
</template>

<script>
import SongService from '../../services/song.services';

export default {
  props: ['song', 'albums', 'artists', 'genres', 'removeSongFromList'],
  data() {
    return {
      songToModify: JSON.parse(JSON.stringify(this.song)),
      urlPreview: `/play/${this.song.id}`,
      preview: false,
    };
  },
  methods: {
    validateMeta() {
      SongService.updateSong(this.songToModify);
    },
    deleteSong() {
      SongService.deleteSong(this.song.id).then(() => {
        this.removeSongFromList(this.song.id);
      });
    },
  },
};
</script>

<style lang="scss" scoped="true">


</style>

