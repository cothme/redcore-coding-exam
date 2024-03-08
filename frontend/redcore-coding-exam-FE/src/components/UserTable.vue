<template>
    <div>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.full_name }}</td>
            <td>{{ user.email }}</td>
            <td>
              <button style="background: green;" class="actionbutton">Update</button>
              <button style="background: red;" @click="deleteUser(user.id)" class="actionbutton">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
import axios from 'axios';

export default {
  data() {
    return {
      users: []
    };
  },
  async mounted() {
    try {
      const accessToken = localStorage.getItem('accessToken');
      const response = await axios.get('http://127.0.0.1:8000/api/user', {
        headers: {
          'Authorization': `Bearer ${accessToken}`
        }
      });
      this.users = response.data.data; 
    } catch (error) {
      console.error(error);
      // Handle error
    }
  },
  methods: {
    async deleteUser(userId) {
      try {
        const accessToken = localStorage.getItem('accessToken');
        await axios.delete(`http://127.0.0.1:8000/api/user/${userId}`, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
       
        this.users = this.users.filter(user => user.id !== userId);
        alert('User deleted successfully');
      } catch (error) {
        console.error(error);
        alert('Failed to delete user. Please try again.');
      }
    }
  }
};
</script>

<style scoped>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #000000;
    padding: 8px;
    text-align: left;
  }
  
  th {
    background-color: #60645e;
  }
  </style>