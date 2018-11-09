<template>
  <div id="main">
    <header class="header-page">
      <h1>VOCARDS</h1>
      <div>
        <!-- <button v-if="!closed" @click="newGroup()" class="circle">+</button> -->
        <img class="add-image" src="images/plus.svg" @click="newGroup()">
        <button class="btn" @click="showAlertSave = true">Enregistrer</button>
        <button class="btn white-btn" @click="showAlertReset = true">Réinitialiser </button>
        <button class="btn white-btn" @click="showAlertReconfig = true">Reconfigurer </button>
      </div>
    </header>
    <div class="list-sorter">
        <div
          v-for="(group, index) in groups"
          v-bind:key="index"
          class="group"
          @drop="drop($event, group.list)"
          @dragover="allowDrop($event)"
          >
          <header>
            <textarea :disabled="closed" v-model="group.name"></textarea>
            <button v-if="!closed" class="delete-group" @click="deleteGroup(group)">x</button>
          </header>
          <div
            v-for="(song, index) in group.list.songs"
            v-bind:key="index"
            draggable="true" @dragstart="drag($event, song, group.list)"
            class="song-container">
              <Song
                :song="song"/>
          </div>
        </div>
    </div>
    <div class="song-list"
       @drop="drop($event, list)"
       @dragover="allowDrop($event)"
    >
      <h2>Glisser-déposer les sons ci-dessous dans les colonnes
        pour les organiser en groupes cohérents</h2>
      <div class="song-container" v-for="(song, index) in list.songs"
        v-bind:key="index" draggable="true"
        @dragstart="drag($event, song, list)">
       <Song
        :song="song"/>
      </div>
    </div>
    <modal v-if="showAlertSave" @ok="storeGroups()" @cancel="showAlertSave = false">
      <h3 slot="header">Souhaitez vous enregistrer ces groupes ?</h3>
    </modal>
    <modal v-if="showAlertReset" @ok="initializeGroups()" @cancel="showAlertReset = false">
      <h3 slot="header">Voulez vous réinitialiser ces groupes ?</h3>
    </modal>
    <modal v-if="showAlertReconfig" @ok="goBackToConfig()" @cancel="showAlertReconfig = false">
      <h3 slot="header">Voulez vous revenir à la configuration d'un tri ?</h3>
    </modal>
  </div>
</template>

<script>
import SongService from './services/song.services';
import SortService from './services/sort.services';
import SongList from './SongList';
import Song from './Song';
import Modal from './Modal';

export default {
  components: { Song, Modal },
  data() {
    return {
      groups: [],
      list: new SongList(),
      closed: true,
      min: null,
      max: null,
      initialParams: {},
      songs: [],
      showAlertSave: false,
      showAlertReset: false,
      showAlertReconfig: false,
    };
  },
  created() {
    this.initialParams = this.$route.params;
    if (this.initialParams.closed === undefined) {
      this.$router.push({ name: 'setup' });
    } else {
      SongService.getSongsToValidate().then((response) => {
        this.songs = response.data;
        this.list.songs = this.songs;
        this.initializeGroups();
      });
    }
  },
  methods: {
    newGroup() {
      if (this.groups.length < this.max) {
        this.groups.push({
          name: `Label ${this.groups.length + 1}`,
          list: new SongList(),
        });
      }
    },
    drag(event, song, list) {
      this.currentSongDragged = song;
      this.currentList = list;
    },
    drop(event, list) {
      this.currentList.songs =
      this.currentList.songs.filter(elem => elem !== this.currentSongDragged);
      list.songs.push(this.currentSongDragged);
    },
    deleteGroup(group) {
      if (this.groups.length > this.min) {
        this.list.songs.push(...group.list.songs);
        this.groups = this.groups.filter(g => g !== group);
      }
    },
    allowDrop(event) {
      event.preventDefault();
    },
    goBackToConfig() {
      this.showAlertReconfig = false;
      this.$router.push({ name: 'setup' });
    },
    initializeGroups() {
      this.showAlertReset = false;
      const {
        closed, groups, min, max,
      } = this.initialParams;
      this.closed = closed;
      if (closed) {
        this.groups = [];
        groups.forEach((group) => {
          this.groups.push({
            name: group.name,
            list: new SongList(),
          });
        });
      } else {
        this.min = min;
        this.max = max;
        this.groups = [];
        for (let i = 0; i < min; i += 1) {
          // const element = array[i];
          this.newGroup();
        }
      }
      this.list.songs = this.songs;
    },
    storeGroups() {
      SortService.storeSort({
        closed: this.closed,
        min: this.min,
        max: this.max,
        groups: this.groups.map(group => ({
          name: group.name,
          songs: group.list.songs.map(song => song.id),
        })),
      }).then(() => {
        this.showAlertSave = false;
        this.$router.push({ name: 'sorts' });
      });
    },
  },
};
</script>

<style lang="scss" scoped>

#main{
   width: 100%;
  height: 100%;
}

.add-image{
  width: 38px;
  vertical-align: middle;
}

.header-page{
  padding-top: 10px;
  padding-bottom: 10px;
  button{

    &.circle{
      width: auto;
      padding: 6px;
      height: 40px;
      width: 40px;
      border-radius: 50%;
      background: transparent;
      color: #6255AB;
      border: 1px solid #6255AB;
      font-size: 34px;
      line-height: 0px;
      vertical-align: middle;
    }
  }
}

#main{
  display: flex;
  flex-direction: column;
  background: #f4f6fe;
  h1{
    color: #6255AB;
    margin: 0px;
    font-weight: 300;
    margin-left: 20px;
  }
  .list-sorter{
    height: 65%;
    display: flex;
    width: calc( 100% - 40px);
    overflow-x: auto;
    padding: 20px;
    padding-top: 0px;
    align-items: flex-start;
    .group{
      background-color: white;
      border: 1px solid #E5E5E5;
      border-radius: 3px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      max-height: 100%;
      position: relative;
      white-space: normal;
      min-width: 200px;
      margin-left: 5px;
      margin-right: 5px;
      height: 100%;
      .song{
        background: #6255AB;
      }
    }
  }
  .song-list{
    background: #fff;
    border-top: 10px solid #6255AB;
    height: 35%;
    padding: 0px 20px;
    h2{
      color: #6255AB;
      font-size: 15px;
      font-weight: 300;
      margin-left: 10px;
    }
    .song{
      background: #515151;
    }
  }
  .song-container{
    display: inline-block;
    margin: 10px;
    margin-bottom: 0px;
  }
}
textarea {
    background: transparent;
    border-radius: 3px;
    box-shadow: none;
    font-weight: 700;
    height: 20px;
    min-height: 20px;
    margin-top: 2px;
    margin-left: 2px;
    padding: 4px 7px;
    resize: none;
    font-size: 16px;
    max-height: 256px;
    width: 70%;
    display: inline-block;
    color: #6255AB;
    border: 0px;
    border-left: 5px solid #6255AB;
    padding-left: 6px;
    margin-left: 0px;
    margin-top: 0px;
  &:focus {
    background: #fff;
    border: 1px solid #5ba4cf;
    box-shadow: 0 0 0 1px #5ba4cf;
  }
}


header{
  display: flex;
  justify-content: space-between;
  text-transform: uppercase;
  .delete-group{
    display: inline-block;
    width: 10%;
    margin-right: 5px;
    background: none;
    border:none;
    outline: none;
  }
}
</style>
