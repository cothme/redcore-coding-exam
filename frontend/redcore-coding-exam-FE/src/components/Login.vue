<template>
    <div class="container">
        
        <form @submit.prevent="login">
            <h1>LOGIN</h1>
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
    </div>
</template>

<script>
export default{

}
</script>