<template>
    <div class="snackbar" :class="type">
        {{ message }}
    </div>
</template>

<script>

export default{
    name:'ViewResponse',
    props:{
        message:{
            
        },
        type:{
            

        }
    }
}

</script>

<style scoped>


.snackbar {
    font-size: 22px;
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px 20px;
    border-radius: 4px;
    color: #fff;
    z-index: 9999;
    transition: all 0.3s ease;
}

.success {
    background-color: #4CAF50;
}

.error {
    background-color: #F44336;
}
</style>