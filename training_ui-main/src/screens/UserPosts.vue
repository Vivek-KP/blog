<template>
    <div>
        <div class="postView p-5 my-5 d-flex flex-column justify-content-between">
            <div>
                <h2 class="text-center  text-white p-3">{{ post.title }}</h2>
                <h5 class="text-white">{{ post.content }}</h5>
            </div>
            <div class="d-flex justify-content-between p-2">
                <button @click="updatePost(post.id)" class="updateButton">Edit</button>
                <button @click="deletePost(post.id)" class="deleteButton">Delete</button>

            </div>
            <div v-if="update" class="modal-overlay">

                <div class="modal-content p-3">
                    <i class="material-icons-outlined d-flex justify-content-end close p-1"
                        @click="update = false">close</i>


                    <form @submit.prevent="updatePostSubmit(post.id)">
                        <h4 class="text-center text-white">Update Post</h4>
                        <label class="text-white" for="title">Title</label><br>
                        <input class="inputField text-lg-left" id="title" type="text" v-model="postTitle"
                            placeholder="Enter a title"><br>
                        <span v-for="error in v$.postTitle.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>
                        <label class="text-white" for="content">Content</label><br>
                        <textarea class="text-lg-left" rows="10" cols="36" v-model="postContent"
                            placeholder="Content goes here"></textarea><br>
                        <span v-for="error in v$.postContent.$errors" :key="error.$uid">
                            {{ error.$property }}-{{ error.$message }}<br>
                        </span>
                        <button class="loginButton p-2" type="submit">update</button>
                    </form>

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
import { required } from '@vuelidate/validators'
import ViewResponse from './ViewResponse.vue';

export default {

    name: 'UserPosts',

    components: { ViewResponse },

    setup() {
        return { v$: useVuelidate() }
    },

    data() {
        return {
            update: false,
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
    props: {
        post: {
            type: Object
        },
        fetchApost: {

        }
    },


    methods: {
        async deletePost(postId) {
            this.show = true;
            setTimeout(() => {
                this.show = false;
            }, 3000);
            try {
                const userId = localStorage.getItem("id")
                const response = await axios.delete('http://professional.test/training/v1/post/' + userId + '/' + postId);

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
            this.fetchApost()

        },
        async updatePost(postId) {
            this.update = true;
            const response = await axios.get('http://professional.test/training/v1/post/p1/' + postId);
            this.postTitle = response.data.data.title
            this.postContent = response.data.data.content

        },
        async updatePostSubmit(postId) {

            const userId = localStorage.getItem("id")
            const isFormCorrect = await this.v$.$validate()
            if (isFormCorrect) {
                try {
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                    const response = await axios.post('http://professional.test/training/v1/post/update/' + userId + '/' + postId
                        , { title: this.postTitle, content: this.postContent });

                    if (response.data.status == 'success') {
                        this.type = 'success'
                        this.message = response.data.status;
                        this.update = false
                        this.fetchApost()
                    } else {
                        this.type = 'error'

                        this.message = response.data.message;
                    }

                } catch (error) {
                    this.message = error
                    this.type = 'error'

                }
            } else {
                console.log("something went wrong ");

            }
        }
    },


}

</script>



<style scoped>
h2 {
    background-color: rgb(38, 71, 102);
}

.postView {
    background-color: rgb(25, 47, 67);
    border-radius: 18px;
    box-shadow: 0px 5px 15px rgb(4, 4, 4);
    height: 80vh;
    width: 92%;
}

.updateButton {
    text-align: center;
    color: white;
    background-color: rgb(4, 252, 186);
    font-size: 22px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    outline: none;
    cursor: pointer;
    width: 25%;

}

.deleteButton {
    text-align: center;
    color: white;
    background-color: rgb(247, 49, 49);
    font-size: 22px;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    outline: none;
    cursor: pointer;
    width: 25%;


}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.455);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: rgb(25, 47, 67);
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    display: flex;
    flex-direction: column;
    max-width: 500px;
    width: 100%;
    color: white;
}

.close {
    color: white;
    font-size: 28px;
}

.close:hover {
    cursor: pointer;

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