<template>
    <div>
      <table class="table">
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
              <button type="button" class="btn btn-danger" style="background: green;" data-bs-toggle="modal" :data-bs-target="'#exampleModal'+user.id">Update</button>
              <div class="modal fade" :id="'exampleModal'+user.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="updateUser(user.id)">
                        <h1 class="d-flex">Update User</h1>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Full Name</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="updatedUsers.full_name">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Email</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="updatedUsers.email">
                          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Role</label>
                          <select class="form-select" aria-label="Default select example" v-model="updatedUsers.selectedRolebyId">
                            <option v-for="role in roles" :key="role.id">{{ role.role_name }}</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword2" class="form-label">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" v-model="updatedUsers.password">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword2" v-model="updatedUsers.password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div> 
                  </div>
                </div>
              </div>
              <button style="background: red;" @click="deleteUser(user.id)" class="btn btn-danger outline-none mx-2">Delete</button>
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
      roles:[],
      updatedUsers:{
        id: '',
        selectedRolebyId: '',
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
      const roleResponse = await axios.get('http://127.0.0.1:8000/api/role', {
        headers: {
          'Authorization': `Bearer ${accessToken}`
        }
      });
      this.roles = roleResponse.data.data;
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    userRoles() {
      return this.roles
    },
    async get() {
      try {
        const accessToken = localStorage.getItem('accessToken');
        const response = await axios.get('http://127.0.0.1:8000/api/role', {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        this.roles = response.data.data;
      } catch (error) {
        console.error(error);
      }
    },
    async updateUser(userId) {
      try {
        const accessToken = localStorage.getItem('accessToken');
        await axios.put(`http://127.0.0.1:8000/api/user/${userId}`, this.updatedUsers, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        this.$router.push('/');
        alert('User updated successfully');
      } catch (error) {
        console.error(error);
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
      }
    }
  }
};
</script>

