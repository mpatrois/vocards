<template>
   <div class="song" :class="{'playing' : playing }" :style="{
       background: playing ? '#7ACBE8' : null
   }">
       <template class="icon-play">
            <i class="material-icons" v-if="!playing" @click="play()">
                play_arrow
            </i>
            <i class="material-icons" v-else @click="pause()">
                stop
            </i>
       </template>
        <span>
            {{song.title}}
        </span>
        <span class="description" v-if="displayDescription">
           : "{{song.description}}"
        </span>
        <i class="material-icons drag_indicator">
            drag_indicator
        </i>
        <audio id="player" ref="audio" :src = "`/play/${song.id}`"></audio>
    </div>
</template>
<script>
export default {
  props: ['song', 'displayDescription'],
  data() {
    return {
      playing: false,
    };
  },
  created() {
    this.$eventHub.$on('song_playing', this.listenForOtherPlay);
  },
  beforeDestroy() {
    this.$eventHub.$off('song_playing', this.listenForOtherPlay);
  },
  methods: {
    pause() {
      this.$refs.audio.pause();
      this.$refs.audio.currentTime = 0;
      this.playing = false;
    },
    play() {
      this.$refs.audio.play();
      this.$eventHub.$emit('song_playing', this.song.id);
      this.playing = true;
      this.$refs.audio.onended = () => {
        this.playing = false;
      };
    },
    listenForOtherPlay(id) {
      if (this.song.id !== id) {
        if (this.playing) {
          this.pause();
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.song{
    min-width: 140px;
    background: #FD8E81;
    color: white;
    padding: 2px;
    position: relative;
    span, i {
        vertical-align: middle;
        display: inline-block;
    }
    .drag_indicator{
        position: absolute;
        right: 2px;
    }
    .description{
        width: 75%;
        overflow: hidden;
        white-space: nowrap;
        text-align: left;
        text-overflow: ellipsis;
    }
}

</style>
