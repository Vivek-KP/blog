<template>

    <div style="width: 50%;">
        <div class="postView p-5 my-5 d-flex flex-column justify-content-between">
            <div class="titleAndContent">
                <h2 class="text-center  text-white p-3">{{ post.title }}</h2>
                <h5 class="postDetails text-white">{{ post.content }}</h5>
            </div>
            <button class="p1" @click.prevent="comment(post.id)">Comment</button>
            <div v-if="enable" class="modal-overlay">

                <div class="modal-content">
                    <i class="material-icons-outlined d-flex justify-content-end close p-1"
                        @click="closeButtonClicked">close</i>

                    <div class="modal-body" v-for="comment in commentDetails" :key="comment.id"
                        style="overflow-y: auto; max-height: 80vh;">
                        <div class="commentClick d-flex justify-content-between"
                            @click.prevent="commentClick(comment.id)">
                            {{ comment.comment }}

                            <i v-if="comment.id == DeleteCommentId" @click.prevent="deleteAComment(comment.id, post.id)"
                                class="material-icons-outlined deleteIcon">delete</i>
                        </div>

                    </div>

                    <div class="p-3 d-flex justify-content-between">
                        <input class="w-75 border-right-0 border-left-0 border-top-0 " name="commentInput" type="text"
                            v-model="newComment" placeholder="Enter a comment">
                        <i class="send material-icons-outlined pt-1" @click.prevent="addComment(post.id)">send</i><br>

                    </div>
                    <span class="pl-3" v-for="error in v$.newComment.$errors" :key="error.$uid">
                        {{ error.$message }}<br>
                    </span>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>
import axios from 'axios';
import useVuelidate from '@vuelidate/core'
import { required } from '@vuelidate/validators'

export default {
    name: "ViewAllPosts",

    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            newComment: { required },

        }
    },
    props: {
        post: {
            type: Object
        }
    },
    data() {
        return {
            enable: false,
            DeleteCommentId: '',
            commentDetails: [],
            newComment: '',


        }
    },
    methods: {
        async comment(postId) {

            this.enable = true
            this.v$.$reset()
            try {
                const response = await axios.get('http://professional.test/training/v1/comment/' + postId);
                this.commentDetails = response.data.data
            } catch (error) {
                console.error(error);
            }
        },
        async addComment(postId) {
            const isFormCorrect = await this.v$.$validate()
            if (isFormCorrect) {

                try {
                    const userId = localStorage.getItem('id')

                    const response = await axios.post('http://professional.test/training/v1/comment/', {
                        comment: this.newComment,
                        userId: userId,
                        postId: postId,
                        createdBy: userId
                    });
                    console.log(response.data);
                    this.comment(postId)//to display the posted comment 

                } catch (error) {
                    console.error(error);
                }
            } else {
                console.log("something wend wrong");
            }
            this.newComment = ''

        },
        async commentClick(commentId) {
            const response = await axios.get('http://professional.test/training/v1/comment/comment/' + commentId)
            const userId = localStorage.getItem('id')

            if (userId == response.data.data.user_id) {

                this.DeleteCommentId = commentId
            }
        },
        async deleteAComment(commentId, postId) {
            const response = await axios.delete('http://professional.test/training/v1/comment/' + commentId)
            console.log(response.data);
            this.comment(postId)//to display the posted comment 

        },
        closeButtonClicked() {
            this.enable = false
            this.deleteComment = false
            this.newComment = ''

        }
    }
}

</script>


<style scoped>
h2 {
    background-color: rgb(38, 71, 102);
}

.send {
    color: rgb(4, 252, 186);
    font-size: 37px;

}

.send:hover {
    cursor: pointer;
}

.close {
    color: white;
    font-size: 28px;
}

.close:hover {
    cursor: pointer;

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

.modal-body {
    padding: 16px;
    flex: 1;
}

.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 8px 16px;
    border-top: 1px solid rgb(4, 252, 186);
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

.postView {
    background-color: rgb(25, 47, 67);
    border-radius: 18px;
    box-shadow: 0px 5px 15px rgb(4, 4, 4);
    height: 80vh;
    width: 92%;
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

.commentClick:hover {
    cursor: pointer;
}

.deleteIcon:hover {
    cursor: pointer;
}

span {
    color: red;
}

input:focus {

    border: 2px solid rgb(4, 252, 186);
}
</style>