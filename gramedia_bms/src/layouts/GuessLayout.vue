<template>
  <div class="">
    <q-layout>
      <q-page-container style="min-height: 100vh">
        <div class="row" style="min-height: 100vh">
          <div class="col-md-8 d-sm-none">
            <q-img :src="url" style="min-height: 100%" spinner-color="white" />
          </div>
          <div class="col-md-4 col-sm-12">
            <router-view></router-view>
          </div>
        </div>
      </q-page-container>
    </q-layout>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';

export default defineComponent({
  name: 'GuessLayout',
  setup() {
    const url = ref('https://source.unsplash.com/random?gramedia');
    return {
      url,
    };
  },
});
</script>
