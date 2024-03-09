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
    <div class="buttons">
      <button class="createbutton" v-if="selectedOption === 'Role'" data-bs-toggle="modal" data-bs-target="#createRoleModal">Create Role</button>
      <button class="createbutton" v-else-if="selectedOption === 'User'" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
    </div>
    <!-- Conditionally render the selected table component -->
    <div class="home">
      <RoleTable v-if="selectedOption === 'Role'"></RoleTable>
      <UserTable v-else-if="selectedOption === 'User'"></UserTable>
    </div>
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form @submit.prevent="createaUser">  
                    <h1>Create User</h1>
                    <label>Full Name:</label>
                    <input type="text" v-model="createUser.full_name">

                    <label>Email:</label>
                    <input type="text" v-model="createUser.email">

                    <label>Password:</label>
                    <input type="password" v-model="createUser.password">

                    <label>Confirm Password:</label>
                    <input type="password"  v-model="createUser.password_confirmation">
                      <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="createaUser()">Create User</button>
                  </div>
                    </form>
                  </div> 
                </div>
              </div>
            </div>
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form @submit.prevent="createaRole">  
                      <h1>Create Role</h1>
                      <label>Role Name:</label>
                      <input type="text" v-model="createRole.role_name">
                      <label>Description:</label>
                      <input type="text" v-model="createRole.description">
                      <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="createaRole()">Create Role</button>
                  </div>
                    </form>
                  </div> 
                </div>
              </div>
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
      selectedOption: 'User',
      createRole:{
        role_name: '',
        description: ''
      },
      createUser:{
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
        alert('Failed to create role. Please try again.');
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
        alert('Failed to create user. Please try again.');
        console.log(this.createUser)
      }
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
.createbutton{
  border-radius: 3px;
  width: 150px;
  height: 25px;
  margin: 10px;
  color: white;
  background: rgb(44, 4, 224);
}
</style>
