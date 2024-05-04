<template>
    <div>
        <div class="loginContainer d-flex justify-content-center align-content-center flex-wrap container">

            <div class="d-flex justify-content-center">
                <div class="">
                    <div class="blueContainer p-5 h-100">
                        <h1 class="welcome">Welcome</h1>

                    </div>
                </div>
                <div class="">
                    <div class="formContainer bg-white p-4">
                        <h1>Login</h1>
                        <form @submit.prevent="login">
                            <i class="material-icons-outlined">email</i>
                            <input class="inputField" id="email" type="email" v-model="userEmail"
                                placeholder="Enter email address"><br>
                            <span v-for="error in v$.userEmail.$errors" :key="error.$uid">
                                {{ error.$property }}-{{ error.$message }}<br>
                            </span>


                            <i class="material-icons-outlined">lock</i>
                            <input class="inputField" id="name" type="password" v-model="userPassword"
                                placeholder="Enter password"><br>
                            <span v-for="error in v$.userPassword.$errors" :key="error.$uid">
                                {{ error.$property }}-{{ error.$message }}<br>
                            </span>


                            <div class="d-flex justify-content-end">
                                <a href="#">Forgot password</a><br>

                            </div>

                            <div class="d-flex justify-content-center">

                                <button class="loginButton   m-4" type="submit">Login</button>

                            </div>

                        </form>
                        <div class="d-flex justify-content-between">
                            <p>Don't have an account?</p>
                            <button class="signupButton " @click.prevent="signUpFunction()">Signup</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div v-if="show">
            <ViewResponse :message="message" :type="type" />
        </div>
    </div>
</template>



<script>

import axios from 'axios';
import useVuelidate from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'
import ViewResponse from './ViewResponse.vue';

export default {
    name: 'LoginPage',
    components: { ViewResponse },
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            userEmail: '',
            userPassword: '',
            show: false,
            message: '',
            type: ''
        }
    },
    validations() {
        return {
            userEmail: { required, email },
            userPassword: { required }
        }
    },
    methods: {

        signUpFunction() {
            this.$router.push('/signup')

        },
        async login() {
            const isFormCorrect = await this.v$.$validate();
            if (isFormCorrect) {

                this.show = true;
                setTimeout(() => {
                    this.show = false;
                }, 3000);
                try {

                    const response = await axios.post('http://professional.test/training/v1/user/login',
                        { email: this.userEmail, password: this.userPassword });
                    if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;
                        localStorage.setItem("id", response.data.data.id)
                        this.$router.replace('/home')
                    }
                    else {
                        this.type = 'error'

                        this.message = response.data.message;
                    }
                } catch (error) {
                    this.message = error
                    this.type = 'error'
                }
            } else
                console.log('something went wrong')
        }
    }
}
</script>



<style scoped>
h1 {
    text-align: center;
}

span {
    color: red;
}




.formContainer {
    width: 120%;
    border-radius: 0px 20px 20px 0px;
    box-shadow: 0px 5px 20px rgb(5, 5, 5);


}

.loginContainer {
    height: 100vh;
}

.blueContainer {
    width: 400px;
    border-radius: 20px 0px 0px 20px;
    box-shadow: -5px 5px 15px rgb(1, 1, 1);
    background-color: rgb(25, 47, 67);

}

.welcome {
    color: white;
}

.inputField {
    border: none;
    border-bottom: 1px solid rgb(107, 107, 107);
    outline: none;
    width: 100%;
    text-align: center;
    font-size: 20px;
    transition-duration: 0.5s;

}

input:focus {

    border-bottom: 2px solid rgb(25, 47, 67);
}

.inputField::placeholder {
    text-align: center;
    font-size: large;

}


.material-icons-outlined {
    color: rgb(25, 47, 67);
    position: relative;
    top: 25px;
    right: 4px;
    font-size: 32px;
}



button {
    text-align: center;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    padding: 8px 18px 8px 18px;
    background-color: rgb(25, 47, 67);

}


button:hover {
    background-color: rgb(49, 90, 128);

}



p {
    font-size: 16px;
}
</style>