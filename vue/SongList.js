class SongList {
  constructor() {
    this.id = `_${Math.random().toString(36).substr(2, 9) + Date.now()}`;
    this.songs = [];
  }
}

export default SongList;
