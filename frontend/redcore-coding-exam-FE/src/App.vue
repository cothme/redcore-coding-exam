<template>
  <div class="app">
    <Signup>dsadsaf</Signup>
  </div>
</template>

<script lang="ts">
import Signup from './components/Signup.vue'
import { RouterLink, RouterView } from 'vue-router'
import { defineComponent, reactive, toRefs, ref } from 'vue';

export default defineComponent({
  name: 'App',
  components:{ Signup },
  setup(){
    
  },
  
})
</script>
<style>
  body{
    margin: 0;
    background: #eee;
  }
</style>



