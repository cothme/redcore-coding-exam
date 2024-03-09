<template>
    <div class="container">
        <form @submit.prevent="login">
            <h1>LOGIN</h1>
            <label>Email:</label>
            <input type="text" v-model="email">

            <label>Password:</label>
            <input type="password" v-model="password">
            <div>
                <button class="login" type="submit">Submit</button>
            </div>  
        </form>
        <div style="color: red;" v-if="loginErrors">{{ loginErrors }}</div>

    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
  data() {
    return {
        email: '',
        password: '',
        loginErrors: '',
        registerSuccess: ''
    };
  },
  methods: {
    async login() {
      try {
        const formData = {
            full_name: this.full_name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
        };
        // Make login request to the backend
        const response = await axios.post('http://127.0.0.1:8000/api/login', formData);
        if(response.status === 200){
          const accessToken = response.data.access_token;
          alert('Login Success!')
          localStorage.setItem('accessToken', accessToken);
          this.$router.push('/');
        }else if(response.status === 401){
          alert('Wrong credentials');
        }
      } catch (error) {
          if (error.response && error.response.status === 401) {
            console.error('Error dsafsaf form:', error);
              this.loginErrors = error.response.data.error;
              
          } else {
            console.error('Error submitting form:', error);
            this.loginErrors = 'An unexpected error occurred. Please try again later.';
          }
      }
    }
  }
};
</script>
