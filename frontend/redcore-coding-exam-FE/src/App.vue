<template>
  <div class="app">
    <Nav></Nav>
      <RouterView></RouterView>
   
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { RouterView } from 'vue-router';
import Nav from '@/components/Nav.vue';

export default defineComponent({
  name: 'App',
  components: {
    RouterView,
    Nav
  }
});
</script>

<style>
body {
  margin: 0;
  background: #eee;
}
.app {
  font-family: Arial, sans-serif;

}
</style>




