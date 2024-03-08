<template>
    <form @submit.prevent="login">
        
        <label>Full Name:</label>
        <input type="text" v-model="full_name">

        <label>Email:</label>
        <input type="text" v-model="email">

        <label>Password:</label>
        <input type="password" v-model="password">

        <label>Confirm Password:</label>
        <input type="password"  v-model="password_confirmation">
  
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
    <div style="color: red;" v-if="registrationErrors">{{ registrationErrors }}</div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return { 
            full_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            registrationErrors: ''
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
        await axios.post('http://127.0.0.1:8000/api/register', formData);
        console.log('Registration successful');
    } catch (error) {
        if (error.response && error.response.status === 422) {
            // If 422 error, set the registration errors message from the response
            this.registrationErrors = error.response.data.errors;
            console.log(this.registrationErrors)
        } else {
            // For other errors, display a generic error message
            console.error('Error submitting form:', error);
            this.registrationError = 'An unexpected error occurred. Please try again later.';
        }
    }
}

    }
};

</script>
<style>
    form{
        display: flex;
        flex-direction: column;
        margin: 30px auto;
        background: white;
        text-align: 40px;
        padding: 40px;
        border-radius: 10px;
    }
</style>