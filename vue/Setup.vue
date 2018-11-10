<template>
    <div id="background">
        <router-link
                id="upload-files-link"
                tag="button"
                class="btn white-btn"
                :to="{name: 'upload'}">
                    Ajouter des fichiers audios
                </router-link>
        <div id="setup">
            <form>
                <header>
                    <img class="post-it" src="images/post-it.svg">
                    <h1>VOCARDS</h1>
                </header>
                <p>
                    Interface de tri de cartes permettant l'emploi
                    de fichiers audios.
                </p>
                <input type="checkbox" id="id-name--1" v-model="closed" class="switch-input">
                <label for="id-name--1" class="switch-label">
                    Tri de carte
                    <span class="toggle--on">fermé</span>
                    <span class="toggle--off">ouvert</span>
                </label>
                <div class="settings">
                    <div v-if="closed">
                        <div v-for="(group,index) in groups" v-bind:key="index">
                            <input type="text" v-model="group.name">
                            <img @click="deleteGroup(group)" class="delete-img"
                                src="images/cross.svg">
                        </div>
                        <img class="add-image" src="images/plus.svg" @click="addGroup()">
                    </div>
                    <div v-else>
                        <div class="input-range">
                            <label>Nombre de groupe minimum</label>
                            <input type="number" v-model="min" min="1" :max="max" placeholder="min">
                        </div>
                        <div class="input-range">
                            <label>Nombre de groupe maximum</label>
                            <input type="number" v-model="max" :min="min" placeholder="max">
                        </div>
                    </div>
                </div>
                <div>
                    <router-link
                    id="valid"
                    tag="button"
                    class="btn"
                    :to="{
                        name: 'sort',
                        query: {
                            closed: closed,
                            groups:groups.map((group)=>group.name),
                            min:min,
                            max:max
                        }
                    }">
                        Valider
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      groups: [
        { name: 'Label 1' },
        { name: 'Label 2' },
        { name: 'Label 3' },
      ],
      closed: true,
      min: 1,
      max: 6,
    };
  },
  methods: {
    addGroup() {
      this.groups.push({ name: `Label ${this.groups.length + 1}` });
    },
    deleteGroup(group) {
      this.groups = this.groups.filter(gro => gro !== group);
    },
  },
};
</script>

<style lang="scss" scoped>

#upload-files-link{
    position: absolute;
    top: 0px;
    right: 10px;
}

button{
    height: 40px;
    background: #6255AB;
    outline: none;
    border: none;
    border-radius: 55px;
    color: white;
    font-size: 16px;
    padding: 0px 40px;
    margin-top: 30px;
}

.settings{
    min-height: 195px;
}

#background {
  width: 100%;
  height: 100%;
}
#background {
    background-image: url(/images/bg_image.jpg);
    width: 100%;
    position: relative;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
    background-position-y: 0;
    background-size: cover;
    display:flex;
    align-items: center;
    overflow-y: auto;
}
img{
    width:20px;
}
#setup{
    width: 500px;
    display: block;
    margin:0 auto;
    background: #F4F6FE;
    height: auto;
    position: relative;
    text-align: center;
    box-shadow: 10px, 10p rgba(0, 0, 0, 0.5);
    padding: 40px;
    min-height: 500px;
    .post-it{
        width: 40px;
        margin-top: 20px;
    }
    h1{
        font-weight: 200;
        color: #6255AB;
    }
    input[type='text']{
        border: 0px;
        background: transparent;
        border-bottom: 1px solid #6255AB;
        padding: 5px 0px;
        width: 300px;
        margin-top: 15px;
        outline: none;
    }
    .delete-img{
        width: 20px;
        margin-left: -20px;
        height: 8px;
        cursor: pointer;
    }
    .add-image{
        margin-top: 40px;
        width: 30px;
    }
}

.input-range{
    text-align: center;
    label{
        font-weight: 400;
        width: 230px;
        display: inline-block;
        margin-top: 30px;
    }
    input{
        width: 30px;
    }
}

.switch-input {
  display: none;
}
.switch-label {
  position: relative;
  display: inline-block;
  min-width: 112px;
  cursor: pointer;
  font-weight: 500;
  text-align: left;
  margin: 16px;
  padding: 16px 0 16px 44px;
}
.switch-label:before, .switch-label:after {
  content: "";
  position: absolute;
  margin: 0;
  outline: 0;
  top: 50%;
  -ms-transform: translate(0, -50%);
  -webkit-transform: translate(0, -50%);
  transform: translate(0, -50%);
  -webkit-transition: all 0.3s ease;
  transition: all 0.3s ease;
}
.switch-label:before {
  left: 1px;
  width: 34px;
  height: 14px;
  background-color: #9E9E9E;
  border-radius: 8px;
}
.switch-label:after {
  left: 0;
  width: 20px;
  height: 20px;
  background-color: #FAFAFA;
  border-radius: 50%;
  box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14),
  0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
}
.switch-label .toggle--on {
  display: none;
}
.switch-label .toggle--off {
  display: inline-block;
}
.switch-input:checked + .switch-label:before {
  background-color: #6255AB;
}
.switch-input:checked + .switch-label:after {
  background-color: #6255AB;
  -ms-transform: translate(80%, -50%);
  -webkit-transform: translate(80%, -50%);
  transform: translate(80%, -50%);
}
.switch-input:checked + .switch-label .toggle--on {
  display: inline-block;
}
.switch-input:checked + .switch-label .toggle--off {
  display: none;
}
</style>
