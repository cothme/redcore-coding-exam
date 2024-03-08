<template>
  <div>
    <div class="name">
      <button class="logout" @click="logout">LOGOUT</button>
      <div v-if="user" style="margin-left: 10px;">
        <p>{{ user.full_name }}</p>
      </div>
      <div v-else>Loading...</div>
    </div>

    <div style="display: flex; flex-direction: row; margin: 20px;">
      <select v-model="selectedOption">
        <option value="User">User</option>
        <option value="Role">Role</option>
      </select>
    </div>

    <!-- Conditionally render the selected table component -->
    <div class="home">
      <RoleTable v-if="selectedOption === 'Role'"></RoleTable>
      <UserTable v-else-if="selectedOption === 'User'"></UserTable>
    </div>
  </div>
</template>

<script>
import UserTable from './UserTable.vue';
import RoleTable from './RoleTable.vue';
import axios from 'axios';

export default {
  components: {
    RoleTable,
    UserTable   
  },
  data() {
    return {
      user: null,
      selectedOption: 'User' // Default selected option
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
.home {
  background-color: rgba(33, 72, 64, 0.838);
  align-items: center;
  height: 100vh;
}
.name {
  display: flex;
  flex-direction: row;
}
.logout {
  background: red;
  color: white;
  margin: 3px;  
  justify-self: end;
}
</style>
