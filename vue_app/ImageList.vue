<template>
    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image_name">{{labels['entity.image.name']}}</label>
                    <input type="email" class="form-control" id="image_name" aria-describedby="image_name_help"
                           placeholder="Enter name" v-model="name">
                    <small id="image_name_help" class="form-text text-muted">{{labels['entity.image.name_description']}}</small>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" v-on:change="setFile">
                        <label class="custom-file-label" for="customFile">{{labels['entity.image.labels.choose_file']}}</label>
                    </div>
                </div>
                <div class="form-group">
                    <div>
                        <button type="button" class="btn btn-primary" @click.prevent="create">{{labels['entity.image.labels.save']}}</button>
                    </div>
                </div>
            </form>

            <single-image
                    v-for="image in images"
                    v-bind:image="image"
                    v-bind:key="image.id"
                    v-on:remove="remove(image.id)">
            </single-image>
        </div>
    </div>
</template>

<script>
    import {http} from './http';
    import SingleImage from "./SingleImage.vue";

    export default {
        name: "image-list",
        components: {SingleImage},
        data: () => {
            return {
                name: '',
                file: null,
                labels: [],
                images: []
            }
        },
        methods: {
            remove: function (id) {
                this.images = remove(this.images, (n) => {
                    return n.id !== id
                })
            },
            setFile: function (e) {
                /**
                 * Every time the input for images changes,
                 * this.file takes it's file if there is one
                 */
                if (e.target.files.length > 0) {
                    this.file = e.target.files[0]
                }
            },
            create: function () {
                /**
                 * FormData to upload our image file.
                 */
                let data = new FormData();
                data.append('file', this.file);
                data.append('name', this.name);

                http.post(
                    '/image/create',
                    data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {
                        if (!response.data.errors) {
                            this.file = null;
                            this.name = null;
                            this.images.push(response.data)
                        } else {
                            /**
                             * All the validation errors go to
                             * Vuex store via errorPushmutator
                             */
                            let errors = response.data.errors

                            for (let errorName in errors) {
                                this.$store.commit('errorPush', errorName + ': ' + errors[errorName])
                            }
                        }
                    })
                    .catch(function (error) {
                        console.error('Image create failed')
                    });
            }
        },
        created: function () {
            /**
             * As the component created, we are asking the server
             * to give us a list of images and labels for this view.
             * ImageListView.php contains all the necessary data
             */
            http.get('/image/list')
                .then((response) => {
                    console.log(response);
                    this.images = response.data.images
                    this.labels = response.data.labels
                })
                .catch(function (error) {
                    console.error(error);
                });
        }
    }
</script>

<style scoped>

</style>