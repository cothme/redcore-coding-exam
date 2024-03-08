<!-- Layout.vue -->

<template>
    <div class="nav">
      <nav>
        <ul>
          <li><router-link to="/">Home</router-link></li>
          <li><router-link to="/login">Login</router-link></li>
          <li><router-link to="/signup">Signup</router-link></li>
        </ul>
      </nav>
      <router-view></router-view>
    </div>
  </template>
  
  <script>
  export default {
  }
  </script>
  
<style>
    ul{
        display: flex;
        flex-direction: row;
    }
    li{
        margin-left: 10px;
        margin-right: 10px;
        list-style: none;
        text-decoration: none;
        font-size: 32px;
        color: black;
    }
</style>
  