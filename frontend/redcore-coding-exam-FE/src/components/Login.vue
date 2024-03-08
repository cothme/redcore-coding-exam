<template>
    <div class="container">
        <form @submit.prevent="login">
            <h1>LOGIN</h1>
            <label>Email:</label>
            <input type="text" v-model="email">

            <label>Password:</label>
            <input type="password" v-model="password">
            <div>
                <button type="submit">Submit</button>
            </div>  
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async login() {
      try {
        const formData = {
          email: this.email,
          password: this.password
        };
        // Make login request to the backend
        const response = await axios.post('http://127.0.0.1:8000/api/login', formData);
        const accessToken = response.data.access_token;
        
        // Store access token in localStorage
        localStorage.setItem('accessToken', accessToken);
        
        // Redirect to another page, for example, home page
        this.$router.push('/');
      } catch (error) {
        console.error('Error logging in:', error);
        // Handle login error
      }
    }
  }
};
</script>
