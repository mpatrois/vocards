<template>
   <div class="song" :class="{'playing' : playing }" :style="{
       background: playing ? '#7ACBE8' : null
   }">
       <template class="icon-play">
            <i class="material-icons" v-if="!playing" @click="play()">
                play_circle_outline
            </i>
            <i class="material-icons" v-else @click="pause()">
                pause_circle_outline
            </i>
       </template>
        <span>
            Track {{song.title}}
        </span>
        <i class="material-icons drag_indicator">
            drag_indicator
        </i>
        <audio id="player" ref="audio" :src = "`/play/${song.id}`"></audio>
    </div>
</template>
<script>
export default {
  props: ['song'],
  data() {
    return {
      playing: false,
    };
  },
  methods: {
    pause() {
      this.$refs.audio.pause();
      this.playing = false;
    },
    play() {
      this.$refs.audio.play();
      this.playing = true;
      this.$refs.audio.onended = () => {
        this.playing = false;
      };
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
}

</style>
