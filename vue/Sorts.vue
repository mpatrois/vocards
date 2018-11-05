<template>
    <div>
        <ul>
            <li v-for="(sort,index) in sorts" v-bind:key="index">
                Tri {{sort.closed ? 'fermé' : 'ouvert' }} fait le {{sort.created_at}}
                <ul>
                    <li v-for="group in sort.groups" v-bind:key="group.id">
                        {{group.name}}
                        <ul>
                            <li v-for="song in group.songs" v-bind:key="song.id">
                                {{song.id}} {{song.title}}
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
import SortService from './services/sort.services';

export default {
  data() {
    return {
      sorts: [],
    };
  },
  created() {
    SortService.getSorts().then((response) => {
      this.sorts = response.data;
    });
  },
};
</script>

