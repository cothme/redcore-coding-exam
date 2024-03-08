<template>
    <div>
      <h1>User List</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.full_name }}</td>
            <td>{{ user.email }}</td>
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
        this.users = response.data.data; // Extracting the data array from the response
      } catch (error) {
        console.error(error);
        // Handle error
      }
    }
  };
  </script>
  <style scoped>
  /* Add CSS styles for the table */
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  th {
    background-color: #f2f2f2;
  }
  </style>