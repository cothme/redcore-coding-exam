<template>
    <div class="container">
            <form @submit.prevent="register">  
                <h1>REGISTER</h1>
                <label>Full Name:</label>
                <input type="text" v-model="full_name">

                <label>Email:</label>
                <input type="text" v-model="email">

                <label>Password:</label>
                <input type="password" v-model="password">

                <label>Confirm Password:</label>
                <input type="password"  v-model="password_confirmation">
        
                <div>
                    <button class="signup" type="submit">Submit</button>
            </div>
            </form>
        <div style="color: red;" v-if="registrationErrors">{{ registrationErrors }}</div>
        <div style="color: green;" v-if="registerSuccess">{{ registerSuccess }}</div>
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
            password_confirmation: '',
            registrationErrors: '',
            registerSuccess: ''
        };
    },
    methods: {
        async register() {
            try {
                const formData = {
                    full_name: this.full_name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
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

