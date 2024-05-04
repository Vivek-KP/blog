<template>
    <div>
        <div class="formContainer container  p-5  flex-wrap">
            <form @submit.prevent="updateProfile">
                <i class="material-icons-outlined row justify-content-end pr-3" @click.prevent="edit">edit</i>

                <h1 class="text-center text-white">Profile</h1>

                <label class="text-white pt-3" for="name">Name</label><br>
                <input class="inputField text-lg-left" id="name" type="text" v-model="updateProfileValues.name"
                    :readonly="readonly" placeholder="Enter a name"><br>
                <span v-for="error in v$.updateProfileValues.name.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>


                <label class="text-white pt-3" for="email">Email</label><br>
                <input class="inputField text-lg-left" id="email" type="email" v-model="updateProfileValues.email"
                    value="email" :readonly="readonly" placeholder="Enter a email"><br>
                <span v-for="error in v$.updateProfileValues.email.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>

                <label class="text-white pt-3" for="phone">Phone</label><br>
                <input class="inputField text-lg-left" id="phone" type="text" v-model="updateProfileValues.phone"
                    value="phone number" :readonly="readonly" placeholder="Enter a phone number"><br>
                <span v-for="error in v$.updateProfileValues.phone.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>



                <button class="loginButton p-2 my-5" type="submit">Update</button>

            </form>
            <form @submit.prevent="updatePassword">

                <label class="text-white pt-3" for="oldPassword">Old password</label><br>
                <input class="inputField text-lg-left" id="oldPassword" v-model="updatePasswordValues.oldPassword"
                    type="password" placeholder="Enter the old password"><br>
                <span v-for="error in v$.updatePasswordValues.oldPassword.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>


                <label class="text-white pt-3" for="newPassword">New password</label><br>
                <input class="inputField text-lg-left" id="newPassword" v-model="updatePasswordValues.newPassword"
                    type="password" placeholder="Enter the new password"><br>
                <span v-for="error in v$.updatePasswordValues.newPassword.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>

                <button class="loginButton p-2 my-5" type="submit">Update password</button>


            </form>
            <button @click.prevent="deleteAccount" class="DeleteButton p-2 " type="submit">Delete Account</button>

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

export function validPassword(password) {

    let validNamePattern = new RegExp(`^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$`);
    if (validNamePattern.test(password)) {

        return true;
    }
    return false;
}

export default
    {
        name: 'ProfilePage',
        components: { ViewResponse },

        setup() {
            return {
                v$: useVuelidate()

            }
        },
        data() {
            return {
                show: false,
                message: '',
                type: '',
                readonly: true,
                updateProfileValues: {
                    name: this.$store.state.data.name,
                    email: this.$store.state.data.email,
                    phone: this.$store.state.data.phone,
                },
                updatePasswordValues: {
                    oldPassword: '',
                    newPassword: '',
                },
                enable: true
            }
        },
        validations() {

            return {
                updateProfileValues: {
                    name: { required },
                    email: { required, email },
                    phone: { required },
                },
                updatePasswordValues: {
                    oldPassword: { required },
                    newPassword: {
                        required, password_validation: {
                            $validator: validPassword,
                            $message: "At least 8 characters,Contains at least one uppercase letter,one lowercase letter,one number,one special character"
                        }
                    }
                }
            }

        },
        methods: {
            async updatePassword() {


                const isFormCorrect = await this.v$.updatePasswordValues.$validate()
                if (isFormCorrect) {
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                    try {
                        const userId = localStorage.getItem('id')

                        const response = await axios.post('http://professional.test/training/v1/user/' + userId + '/update',
                            { oldPassword: this.updatePasswordValues.oldPassword, newPassword: this.updatePasswordValues.newPassword });
                        
                        if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;
                    
                    } else {
                        this.type = 'error'

                        this.message = response.data.message;
                    }
                    } catch (error) {
                        this.message = error
                    this.type = 'error'
                    }
                    this.updatePasswordValues.oldPassword=''
                    this.updatePasswordValues.newPassword=''
                    this.v$.$reset()

                } else
                    console.log("something wend wrong");

            },
            edit() {

                this.readonly = false

            },
            async updateProfile() {
                const isFormCorrect = await this.v$.updateProfileValues.$validate()
                if (isFormCorrect) {
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                    try {
                        const userId = localStorage.getItem('id')

                        const response = await axios.post('http://professional.test/training/v1/user/' + userId,
                            { name: this.updateProfileValues.name, email: this.updateProfileValues.email, phone: this.updateProfileValues.phone, password: "psswoe@123WE" });
                        const update = { name: this.updateProfileValues.name, email: this.updateProfileValues.email, phone: this.updateProfileValues.phone } //to store in the session

                        this.$store.commit("getData", update);

                        if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;
                    
                    } else {
                        this.type = 'error'

                        this.message = response.data.message;
                    }
                    } catch (error) {
                        this.message = error
                    this.type = 'error'
                    }
                } else {
                    console.log("something wend wrong");

                }

            },
            async deleteAccount() {
                try {
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                    const userId = localStorage.getItem("id")
                    const response = await axios.delete('http://professional.test/training/v1/user/' + userId);
                    this.commentDetails = response.data.data
                    localStorage.clear
                    this.$router.replace('/signup')
                    if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;
                        
                        
                    } else {
                        this.type = 'error'

                        this.message = response.data.message;
                    }
                } catch (error) {
                    this.message = error
                    this.type = 'error'
                }
            }
        }
    }
</script>


<style scoped>
.formContainer {

    border-radius: 20px 20px 20px 20px;
    height: 70rem;
    box-shadow: 0px 5px 20px rgb(5, 5, 5);
    background-color: rgb(25, 47, 67);

}


input {

    width: 100%;
    font-size: 20px;
    transition-duration: 0.5s;
    outline: none;
    border: none;
    padding: 8px;
    background-color: rgb(38, 71, 102);
    color: white;
}

input:focus {

    border: 2px solid rgb(4, 252, 186);
}


.contentField {
    padding-top: 20px;
    padding-bottom: 20px;
}



.inputField::placeholder {

    font-size: 15px;

}

label {
    font-size: 28px;
    font-weight: bold;



}

.loginButton {
    text-align: center;
    color: white;
    background-color: rgb(4, 252, 186);
    font-size: 22px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    outline: none;
    cursor: pointer;
    width: 100%;

}

.DeleteButton {
    text-align: center;
    color: white;
    background-color: rgb(247, 49, 49);
    font-size: 22px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    outline: none;
    cursor: pointer;
    width: 100%;


}




.material-icons-outlined {
    color: white;
    font-size: 32px;

}

.material-icons-outlined:hover {
    cursor: pointer;
}



span {
    color: red;
}
</style>