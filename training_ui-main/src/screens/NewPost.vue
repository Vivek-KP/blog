<template>
    <div>
        <div class="formContainer container justify-content-center d-flex p-4 d-flex align-items-center flex-wrap">
            <form ref="postForm" @submit.prevent="post">
                <h1 class="text-center text-white">Create Post</h1>

                <label class="text-white" for="title">Title</label><br>
                <input class="inputField text-lg-left" id="title" type="text" v-model="postTitle"
                    placeholder="Enter a title"><br>
                <span v-for="error in v$.postTitle.$errors" :key="error.$uid">
                    {{ error.$property }}-{{ error.$message }}<br>
                </span>
                <div class="contentField">
                    <label class="text-white" for="content">Content</label><br>
                    <textarea class="text-lg-left" rows="10" cols="63" v-model="postContent"
                        placeholder="Content goes here"></textarea><br>
                    <span v-for="error in v$.postContent.$errors" :key="error.$uid">
                        {{ error.$property }}-{{ error.$message }}<br>
                    </span>
                </div>

                <button class="loginButton p-2" type="submit">Post</button>
                <!-- <h1>{{data}}</h1> -->
            </form>

        </div>
        <div v-if="show">
            <ViewResponse :message="message" :type="type" />
        </div>

    </div>
</template>

<script>

import axios from 'axios';
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import ViewResponse from './ViewResponse.vue';

export default
    {
        name: 'NewPost',
        components: { ViewResponse },

        setup() {
            return { v$: useVuelidate() }
        },
        data() {
            return {
                // data:'regfrefgerf',
                postTitle: '',
                postContent: '',
                show: false,
                message: '',
                type: ''
            }
        },
        validations() {
            return {
                postTitle: { required },
                postContent: { required },
            }
        },
        methods: {
            async post() {


                const isFormCorrect = await this.v$.$validate()
                if (isFormCorrect) {
                    this.show = true;

                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                    try {
                        const userId = localStorage.getItem('id')

                        const response = await axios.post('http://professional.test/training/v1/post/add',
                            { title: this.postTitle, content: this.postContent, userId: userId, createdBy: userId });
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
                    this.postTitle= ''
                this.postContent= ''
            this.v$.$reset()

                } else {
                    console.log("something wend wrong");

                }
                
            }
        }
    }</script>


<style scoped>
.formContainer {

    border-radius: 20px 20px 20px 20px;
    box-shadow: 0px 5px 20px rgb(5, 5, 5);
    background-color: rgb(25, 47, 67);
    height: 50rem;

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

textarea {
    transition-duration: 0.5s;
    outline: none;
    font-size: 20px;
    padding: 8px;
    background-color: rgb(38, 71, 102);
    color: white;

}

textarea:focus {
    border: 2px solid rgb(4, 252, 186);

}

textarea::placeholder {
    font-size: 18px;
    font-family: 'Times New Roman', Times, serif;
}


.inputField::placeholder {

    font-size: 15px;

}

label {
    font-size: 28px;
    font-weight: bold;



}

button {
    text-align: center;
    color: white;
    background-color: rgb(4, 252, 186);
    font-size: 22px;
    font-weight: bold;
    border: none;
    border-radius: 12px;
    outline: none;
    cursor: pointer;

    width: 100%;

}

span {
    color: red;
}
</style>