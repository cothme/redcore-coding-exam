<template>
    <div class="container-fluid col-sm d-flex justify-content-center align-items-center vh-100">
  <div class="card">
    <div class="card-body">
      <form>
        <h1 class="d-flex">REGISTER</h1>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="full_name">
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="email">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Role</label>
          <select class="form-select" aria-label="Default select example" v-model="selectedRoleId">
            <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
    setup(){
        const router = useRouter();
        return { router }; 
    },
    data() {
        return { 
            full_name: '',
            email: '',
            password: '',
            selectedRoleId,
            password_confirmation: '',
            registrationErrors: '',
            registerSuccess: '',
        };
    },
    methods: {
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
        async register() {
            try {
                const formData = {
                    full_name: this.full_name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    selectedRoleId : this.selectedRoleId
                };
                await axios.post('http://127.0.0.1:8000/api/register', formData);
                this.registerSuccess = 'Register Successful';
                this.registrationErrors = ''; 
                // Reset form fields
                this.full_name = '';
                this.email = '';
                this.password = '';
                this.password_confirmation = '';
                this.router.push('/login');
                alert('Register Success');
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.registrationErrors = error.response.data.errors;
                    console.log(this.registrationErrors);
                } else {
                    console.error('Error submitting form:', error);
                    this.registrationError = 'An unexpected error occurred. Please try again later.';
                }
            }
        }
    }
};
</script>

