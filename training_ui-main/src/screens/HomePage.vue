<template>
    <div class="body">
        <div class="titleBar sticky-top">
            <h4 class='float-right text-white pr-5 pt-4'>hi {{ $store?.state?.data?.name }}</h4>

            <h1 class="text-white pl-5 pt-4 text-center">The Blogg</h1>
        </div>
        <div class="titleAndContent">
            <div class="row mr-0">
                <div class="col-1">
                    <div class="sideContainer position-fixed d-flex justify-content-center">
                        <div class="allIcons d-flex flex-column mb-3 justify-content-around ">
                            <div class="iconContainer" @click.prevent="home">
                                <i
                                    :class="homeValue ? 'sideIcons activate material-icons p-3' : 'sideIcons material-icons p-3'">home</i>
                            </div>
                            <div class="iconContainer" @click.prevent="newPost">
                                <i
                                    :class="newPostValue ? 'sideIcons activate material-icons p-3' : 'sideIcons material-icons p-3'">add</i>

                            </div>
                            <div class="iconContainer" @click.prevent="profile">
                                <i
                                    :class="profileValue ? 'sideIcons activate material-icons p-3' : 'sideIcons material-icons p-3'">person</i>

                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="homeValue" class="col-11 d-flex align-items-center p-5 flex-column mb-3">

                    <ViewAllPosts v-for="post in postDetails" :key="post.id" :post="post" />


                </div>
                <div v-else-if="newPostValue" class="col-11 d-flex align-items-center p-5 flex-column mb-3">
                    <NewPost />
                </div>
                <div v-else-if="profileValue" class="col-11  align-items-center p-5 flex-column mb-3">

                    <ProfilePage />
                    <hr class="mt-5">
                    <div class="grid-container">
                        <!-- <div class="postView p-5 my-5" v-for="post in postDetailsOfAUser" :key="post.id"> -->
                        <UserPosts v-for="post in postDetailsOfAUser" :key="post.id" :post="post"
                            :fetchApost="getAllPostsOfaUser" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>


<script>

import axios from 'axios';
import NewPost from './NewPost.vue'
import ProfilePage from './ProfilePage.vue'
import ViewAllPosts from './ViewAllPosts.vue';
import UserPosts from './UserPosts.vue';

export default {
    name: 'HomePage',
    components: { NewPost, ProfilePage, ViewAllPosts, UserPosts },

    data() {
        return {
            homeValue: true,
            newPostValue: false,
            profileValue: false,
            postDetails: [],
            postDetailsOfAUser: [],
        }
    },

    created() {
        this.getPosts()
    },

    async mounted() {
        const userId = localStorage.getItem('id')
        const response = await axios.get('http://professional.test/training/v1/user/' + userId)
        this.$store.commit("getData", response.data.data);

    },

    methods: {
        home() {

            this.homeValue = true;
            this.newPostValue = false;
            this.profileValue = false;
            this.getPosts()
        },
        newPost() {

            this.homeValue = false
            this.newPostValue = true
            this.profileValue = false


        },
        profile() {
            this.homeValue = false
            this.newPostValue = false
            this.profileValue = true
            this.getAllPostsOfaUser()

        },
        async getPosts() {
            await axios.get('http://professional.test/training/v1/post/all/')
                .then(response => {
                    console.log(response)
                    this.postDetails = response.data.data
                }).
                catch(() => {
                }).
                finally(() => {
                })


        },
        async getAllPostsOfaUser() {
            try {
                const userId = localStorage.getItem('id')
                const response = await axios.get('http://professional.test/training/v1/post/all/'.concat(userId));
                this.postDetailsOfAUser = response.data.data
            } catch (error) {
                console.error(error);

            }
        },

    }
}
</script>

<style scoped>
.body {
    background-color: rgb(18, 35, 51);
}

.sideContainer {
    height: 100vh;
    width: 100px;
    background-color: rgb(25, 47, 67);


}

h1 {
    font-family: 'Great Vibes', cursive;
    font-family: 'Roboto Slab', serif;
    font-weight: bold;
}

h2 {
    background-color: rgb(38, 71, 102);


}


.sideIcons:hover {
    cursor: pointer;
    color: white;
    background-color: rgb(4, 252, 186);
    font-size: 40px;

}


.sideIcons {
    color: rgb(4, 252, 186);
    font-size: 35px;
    background-color: white;
    border-radius: 12px;
    /* box-shadow: -5px 5px 15px gray; */
    transition-duration: 0.5s;

}


.titleBar {

    background-color: rgb(18, 35, 51);
    box-shadow: -5px 5px 15px rgb(0, 0, 0);
    width: 100%;
    height: 100px;

}

hr {
    background-color: rgb(4, 252, 186);
}

.activate {
    color: white;
    background-color: rgb(4, 252, 186);
    font-size: 40px;

}




.grid-container {
    display: grid;
    grid-template-columns: auto auto;



}
</style>