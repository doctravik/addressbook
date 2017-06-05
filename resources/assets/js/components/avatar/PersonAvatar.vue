<template>
    <div class="page-header">
        <div class="media">
            <div class="media-left">
                <img v-if="hasAvatar" :src="path" alt="avatar">
                <img v-else src="https://placehold.it/100x100" alt="avatar">
            </div>
            <div class="media-body">
                <h1 class="media-heading" v-text="person.name"></h1>
                <upload-avatar :person="person" @update-avatar="updateAvatar"></upload-avatar>
            </div>
        </div>
    </div>
</template>

<script>
    import UploadAvatar from './UploadAvatar';

    export default {
        props: ['person', 'photoPath'],

        computed: {
            hasAvatar() {
                return !! this.path;
            },
        },

        data() {
            return {
                path: this.photoPath
            }
        },

        methods:{
            /**
             * @param {string} path
             * @return {void}
             */
            updateAvatar(path) {
                this.path = this.person.photo = path;
            }
        },

        components: {UploadAvatar}
    }
</script>
