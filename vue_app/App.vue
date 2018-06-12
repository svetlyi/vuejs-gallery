<template>
    <div>
        <div class="alert-box">
            <div class="alert alert-danger" role="alert" v-for="message in messages">
                {{ message }}
            </div>
        </div>
        <div class="container">
            <image-list></image-list>
        </div>
    </div>
</template>

<script>
    import ImageList from "./ImageList.vue";

    export default {
        name: 'app',
        components: {ImageList},
        computed: {
            messages() {
                return this.$store.state.messages
            }
        },
    }
</script>

<style lang="scss" scoped>
    .alert-box {
        position: absolute;
        top: 10%;
        width: 100%;
        z-index: 99;
    }
</style>