<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title> Book Management System</q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header> Menu </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import EssentialLink from 'components/EssentialLink.vue';
import { LocalStorage } from 'quasar';

const linksList = [
  {
    title: 'Books',
    caption: 'Book Management Menu',
    icon: 'book',
    link: '/admin/books',
  },
  {
    title: 'User',
    caption: 'User Management Menu',
    icon: 'person',
    link: '/admin/users',
  },
  {
    title: 'logout',
    caption: '',
    icon: 'logout',
    link: '/',
  },
];

export default defineComponent({
  name: 'MainLayout',

  components: {
    EssentialLink,
  },
  preFetch({ store, redirect }) {
    if (localStorage.getItem('token') == undefined) {
      redirect({ path: '/' });
    }
    console.log(localStorage.getItem('token'));
  },
  setup() {
    const leftDrawerOpen = ref(false);

    return {
      essentialLinks: linksList,
      leftDrawerOpen,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value;
      },
    };
  },
});
</script>
