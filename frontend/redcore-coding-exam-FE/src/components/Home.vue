<template>
    <div class="name">
        <button class="logout" @click="logout">LOGOUT</button>
        <div v-if="user" style="margin-left: 10px;">
            <p>{{ user.full_name }}</p>
        </div>
        <div v-else>Loading...</div>
    </div>
    <div class="container">
        <RoleTable></RoleTable>
    </div>
  </template>
  
  <script>
  import RoleTable from './RoleTable.vue';
  import axios from 'axios';
 
  
  export default {  
    components: {
        RoleTable   
    },
    data() {
      return {
        user: null
      };
    },
    async mounted() {
      try {
        const accessToken = localStorage.getItem('accessToken');
        if (!accessToken) {
          throw new Error('Access token not found');
        }
        
        const response = await axios.get('http://127.0.0.1:8000/api/user/current', {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        
        this.user = response.data;
      } catch (error) {
        console.error(error);
        // Handle error
      }
    },
    methods: {
    logout() {
      localStorage.removeItem('accessToken');
      alert('Logout successfully')
      this.$router.push('/login');
    }
  }
  };
  </script>

<style>
    .name{
        display: flex;
        flex-direction: row;
    }
    .logout{
        background: red;
        color: white;
        margin: 3px;  
        justify-self: end;
    }
</style>
  