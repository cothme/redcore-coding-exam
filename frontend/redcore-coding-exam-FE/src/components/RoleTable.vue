<template>
  <div>
    <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Role</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="role in roles" :key="role.id">
          <td>{{ role.id }}</td>
          <td>{{ role.role_name }}</td>
          <td>{{ role.description }}</td>
          <td>
              <button type="button" class="btn btn-danger" style="background: green;" data-bs-toggle="modal" :data-bs-target="'#exampleModal'+role.id">Update</button>
              <div class="modal fade" :id="'exampleModal'+role.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Update Role</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form @submit.prevent="updateRole(role.id)">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Role Name</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="updatedRole.role_name">
                        </div>
                        <div class="mb-3">
                          <label for="DESC" class="form-label">Description</label>
                          <input type="text" class="form-control" id="DESC" v-model="updatedRole.description">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Update</button>
                        </div>
                      </form>
                    </div> 
                  </div>
                </div>
              </div>
              <button style="background: red;" @click="deleteRole(role.id)" class="btn btn-danger outline-none mx-2">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
  </div>
</template>

<script>
import axios from 'axios';
import router from '@/router';

export default {
  data() {
    return {
      roles: [],
      updatedRole: {
        id: '',
        role_name: '',
        description: ''
      }
    };
  },
  async mounted() {
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
  methods: {
    async updateRole(roleId) {
      try {
        const accessToken = localStorage.getItem('accessToken');
        await axios.put(`http://127.0.0.1:8000/api/role/${roleId}`, this.updatedRole, {
          headers: {
            'Authorization': `Bearer ${accessToken}`,
            'Accept': 'application/json'
          }
        });
        this.$router.push('/');
        alert('Role updated successfully');
      } catch (error) {
        console.error(error);
        console.log(this.updatedRole)
        alert('Failed to update role. Please try again.');
      }
    },
    async deleteRole(roleId) {
      try {
        const accessToken = localStorage.getItem('accessToken');
        await axios.delete(`http://127.0.0.1:8000/api/role/${roleId}`, {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        });
        this.roles = this.roles.filter(role => role.id !== roleId);
        alert('Role deleted successfully');
      } catch (error) {
        this.$router.push('/');
        console.error(error);
        alert('Failed to delete role. Please try again.');
      }
    }
  }
};
</script>

<style scoped>
table {
  width: 100% !important; 
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
