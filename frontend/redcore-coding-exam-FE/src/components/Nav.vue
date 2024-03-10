<!-- Layout.vue -->

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Login</a>
        </li>

      </ul>
    </div>
  </div>
</nav>
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
  