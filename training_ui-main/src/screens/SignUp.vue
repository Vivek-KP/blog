<template>

    <div>
        <div class="signupContainer d-flex justify-content-center align-content-center flex-wrap container">

            <div class="d-flex justify-content-center">
                <!-- <div class="d-flex flex-row d-flex justify-content-center align-content-center flex-wrap container"> -->
                <div class="blueContainer p-4">
                    <h1 class="welcome">Welcome</h1>

                </div>
                <div class="formContainer p-3">
                    <h1>Signup</h1>
                    <form @submit.prevent="submitForm">

                        <i class="material-icons-outlined">person</i>
                        <input class="inputField" id="name" v-model="userName" type="text" placeholder="Enter name"><br>
                        <span v-for="error in v$.userName.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>


                        <i class="material-icons-outlined">call</i>
                        <input class="inputField" id="phone" v-model="userPhone" type="text"
                            placeholder="Enter phone number"><br>
                        <span v-for="error in v$.userPhone.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>


                        <i class="material-icons-outlined">email</i>
                        <input class="inputField" id="email" v-model="userEmail" type="email"
                            placeholder="Enter email address"><br>
                        <span v-for="error in v$.userEmail.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>


                        <i class="material-icons-outlined">lock</i>
                        <input class="inputField" id="password" v-model="userPassword" type="password"
                            placeholder="Enter password"><br>
                        <span v-for="error in v$.userPassword.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>


                        <i class="material-icons-outlined">lock</i>
                        <input class="inputField" id="confirmPassword" v-model="confirmPassword" type="password"
                            placeholder="confirm password"><br>
                        <span v-for="error in v$.confirmPassword.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>


                        <div class="d-flex justify-content-center">
                            <button class="signupButton m-4 " type="submit">Signup</button>
                            <!-- <input class="signupButton" type="submit" value="Submit"> -->
                        </div>
                    </form>


                    <div class="d-flex justify-content-between">
                        <p>Already have an account?</p>
                        <button class="loginButton " @click.prevent="loginFuction">Login</button>
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
import { required, email, sameAs } from '@vuelidate/validators'
import ViewResponse from './ViewResponse.vue';


export function validPassword(password) {

    let validNamePattern = new RegExp(`^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$`);
    if (validNamePattern.test(password)) {

        return true;
    }
    return false;
}


export default {
    name: 'SignUp',
    components: { ViewResponse },

    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            userName: '',
            userPhone: '',
            userEmail: '',
            userPassword: '',
            confirmPassword: '',
            show: false,
            message: '',
            type: ''
        }
    },
    validations() {
        return {
            userName: { required },
            userPhone: { required },
            userEmail: { required, email },
            userPassword: {
                required,
                password_validation: {
                    $validator: validPassword,
                    $message: "At least 8 characters,Contains at least one uppercase letter,one lowercase letter,one number,one special character"
                }
            },
            confirmPassword: {
                required,
                sameAsPassword: sameAs(this.userPassword)

            }


        }
    },
    methods: {
        loginFuction() {
            this.$router.push('/')


        },
        async submitForm() {
            const isFormCorrect = await this.v$.$validate()
            if (isFormCorrect) {
                this.show = true;
                setTimeout(() => {
                    this.show = false;
                }, 3000);
                try {

                    const response = await axios.post('http://professional.test/training/v1/user/signup',
                        { name: this.userName, phone: this.userPhone, email: this.userEmail, password: this.userPassword });
                    if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;

                        localStorage.setItem("id", response.data.data)
                        this.$router.replace('/home')
                    } else {
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
    },

}
</script>

<style scoped>
h1 {
    text-align: center;
}

span {
    color: red;
}


.signupContainer {
    height: 100vh;
}

.formContainer {
    width: 25rem;
    border-radius: 0px 20px 20px 0px;
    background-color: white;
    box-shadow: 0px 5px 20px rgb(1, 1, 1);


}

.blueContainer {
    width: 25rem;
    border-radius: 20px 0px 0px 20px;
    box-shadow: -5px 5px 15px rgb(4, 4, 4);
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
    border-radius: 18px;
    background-color: rgb(25, 47, 67);
    cursor: pointer;
    padding: 8px 18px 8px 18px;

}


.loginButton {

    margin-top: 0px;
}

button:hover {
    background-color: rgb(47, 86, 123);

}



p {
    font-size: 16px;
}
</style>