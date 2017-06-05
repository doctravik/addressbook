<template>
    <div class="form-group" :class="{'has-error': errors.has('photo')}">
        <label for="file" class="btn btn-default btn-file">
            <span class="glyphicon glyphicon-hourglass" aria-hidden="true" v-show="uploading"></span>
            <span>Update avatar</span>
            <input type="file" id="file" v-show="false" @change="upload" name="photo">
        </label>
        <button type="button" class="btn btn-default" @click="resetForm" v-if="errors.any()">
            <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
        </button>
        <span class="help-block" v-if="errors.has('photo')">
            <strong v-text="errors.get('photo')"></strong>
        </span>
    </div>
</template>

<script>
    import Errors from './../../helpers/ObjectCollection.js';

    export default {
        props: ['person'],

        data() {
            return {
                uploading: false,
                errors: new Errors(),
                endpoint: `/api/persons/${this.person.id}/avatar`
            }
        },

        methods: {
            /**
             * Upload image.
             *
             * @param {Event} e
             * @return {void}
             */
            upload(e) {
                if (e.target.files.length) {
                    this.process(e.target.files);
                }
            },

            /**
             * Handle uploading.
             *
             * @param {FileList} files
             * @return {void}
             */
            process(files) {
                this.uploading = true;

                axios.post(this.endpoint, this.form(files))
                    .then(response => {
                        this.$emit('update-avatar', response.data.path);
                        this.resetForm();
                        this.uploading = false;
                    })
                    .catch(error => {
                        this.errors.record(error.response.data);
                        this.uploading = false;
                    });
            },

            /**
             * Get form data.
             *
             * @return {FormData}
             */
            form(files) {
                let form = new FormData();

                form.append('photo', files[0]);

                return form;
            },

            /**
             * @return {void}
             */
            resetForm() {
                this.errors.clear();
            }
        }
    }
</script>
