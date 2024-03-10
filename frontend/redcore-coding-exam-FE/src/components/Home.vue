<template>
<div>
  <div class="name d-flex align-items-center">
      <ul class="list-unstyled d-flex align-items-center">
        <li>
          <button class="btn btn-danger" @click="logout">LOGOUT</button>
        </li>
        <li v-if="user" style="margin-left: 10px; margin-top: 10px;">
          <h2>{{ user.full_name }}</h2>
        </li>
        <li v-else>Loading...</li>
        <li>
          <button class="btn btn-primary" v-if="selectedOption === 'Role'" data-bs-toggle="modal" data-bs-target="#createRoleModal">Create Role</button>
      <button class="btn btn-primary" v-else-if="selectedOption === 'User'" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
        </li>
      </ul>
      <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Create User</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="createaUser">
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" v-model="createUser.full_name">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Email</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="createUser.email">
                  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Assign Role</label>
                  <select class="form-select" aria-label="Default select example" v-model="createUser.role_id">
                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.role_name }}</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" v-model="createUser.password">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" v-model="createUser.password_confirmation">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div> 
          </div>
        </div>
      </div>
      <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Create Role</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form @submit.prevent="createaRole">
                <h1 class="d-flex"></h1>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Role Name</label>
                  <input type="text" class="form-control" v-model="createRole.role_name">
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Description</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" v-model="createRole.description">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div> 
          </div>
        </div>
      </div>
    </div>
    <div style="display: flex; flex-direction: row; margin: 20px;">
    <select class="form-select w-25" aria-label="Default select example" v-model="selectedOption">
      <option value="User">User</option>
      <option value="Role">Role</option>
    </select>
  </div> 
</div>
<div class="home">
      <RoleTable v-if="selectedOption === 'Role'"></RoleTable>
      <UserTable v-else-if="selectedOption === 'User'"></UserTable>
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
      roles:[],
      selectedOption: 'User',
      createRole:{
        role_name: '',
        description: ''
      },
      createUser:{
        full_name: '',
        role_id: '',
        email: '',
        password: '',
        password_confirmation: '',
      }
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
    logout() {
      localStorage.removeItem('accessToken');
      alert('Logout successfully')
      this.$router.push('/login');
    },
    async createaRole() {
      try {
        const accessToken = localStorage.getItem('accessToken');
        const response = await axios.post('http://127.0.0.1:8000/api/role', this.createRole,{
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        console.log('Role created:', response.data);
        alert('Role created successfully');
      } catch (error) {
        console.error('Error creating role:', error);
      }
    },
    async createaUser() {
      try {
        const accessToken = localStorage.getItem('accessToken');
        const response = await axios.post('http://127.0.0.1:8000/api/register', this.createUser,{
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        console.log('User created:', response.data);
        alert('User created successfully');
      } catch (error) {
        console.error('Error creating user:', error);
      }
    }
  }
};
</script>

