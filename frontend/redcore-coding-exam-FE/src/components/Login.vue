<template>
  <div class="container-fluid col-sm d-flex justify-content-center align-items-center vh-100">
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="login">
          <h1 class="d-flex justify-content-center">LOGIN</h1>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input v-model="password" type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div v-if="loginErrors" class="alert alert-danger m-4">{{ loginErrors }}</div>
      </div>
    </div>
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
    };
  },
  methods: {
    async login() {
      try {
        const formData = {
          email: this.email,
          password: this.password,
        };
        const response = await axios.post('http://127.0.0.1:8000/api/login', formData);
        if (response.status === 200) {
          const accessToken = response.data.token;
          alert('Login Success!')
          localStorage.setItem('accessToken', accessToken);
          this.$router.push('/');
        } else if (response.status === 401) {
          this.loginErrors = 'Wrong credentials';
        }
      } catch (error) {
        if (error.response && error.response.status === 401) {
          console.error('Error from server:', error);
          this.loginErrors = error.response.data.error;
        } else {
          console.error('Error submitting form:', error);
          this.loginErrors = 'An unexpected error occurred. Please try again later.';
        }
      }
    },
  },
};
</script>
