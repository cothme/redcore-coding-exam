<template>
  <div>
    <table>
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
            <button style="background: green;" class="actionbutton">Update</button>
            <button style="background: red;" class="actionbutton" @click="deleteRole(role.id)">Delete</button>
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
      roles: []
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
        console.error(error);
        alert('Failed to delete role. Please try again.');
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
