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
              <button type="button" class="actionbutton" style="background: green;" data-bs-toggle="modal" :data-bs-target="'#exampleModal'+user.id">Update</button>
              <div class="modal fade" :id="'exampleModal'+user.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="updateUser">  
                        <h1>Update {{ user.full_name }}</h1>
                        <label>Full Name:</label>
                          <input type="text" v-model="updatedUsers.full_name">

                          <label>Email:</label>
                          <input type="text" v-model="updatedUsers.email">

                          <label>Password:</label>
                          <input type="password" v-model="updatedUsers.password">

                          <label>Confirm Password:</label>
                          <input type="password"  v-model="updatedUsers.password_confirmation">
                        <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="updateUser(user.id)">Save changes</button>
                    </div>
                      </form>
                    </div> 
                  </div>
                </div>
              </div>
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
      users: [],
      updatedUsers:{
        id: '',
        full_name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }
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
    async updateUser(userId) {
      try {
        const accessToken = localStorage.getItem('accessToken');
        await axios.put(`http://127.0.0.1:8000/api/user/${userId}`, this.updatedUsers, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        alert('User updated successfully');
      } catch (error) {
        console.error(error);
        console.log(this.updatedUsers)
        alert('Failed to update user. Please try again.');
      }
    },
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