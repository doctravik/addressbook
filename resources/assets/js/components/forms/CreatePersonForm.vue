<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Create person</h3>
        </div>

        <div class="panel-body">
            <form @submit.prevent="create()">
                <div class="form-group" :class="{'has-error': errors.has('name')}">
                    <label for="name" class="control-label">Name</label>

                    <input type="text" class="form-control" v-model="form.name"
                        placeholder="name" required autofocus>
                    <span class="help-block" v-if="errors.has('name')">
                        <strong v-text="errors.get('name')[0]"></strong>
                    </span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('age')}">
                    <label for="age" class="control-label">Age</label>

                    <input type="text" class="form-control" v-model="form.age"
                        placeholder="age" required>
                    <span class="help-block" v-if="errors.has('age')">
                        <strong v-text="errors.get('age')[0]"></strong>
                    </span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('city')}">
                    <label for="city" class="control-label">City</label>

                    <input type="text" class="form-control" v-model="form.city"
                        placeholder="city" required>
                    <span class="help-block" v-if="errors.has('city')">
                        <strong v-text="errors.get('city')[0]"></strong>
                    </span>
                </div>

                <button class="btn btn-info">Create</button>
                <button class="btn btn-default" v-if="errors.any()" @click="clear()">
                    Reset
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from './../../helpers/Form.js';

    export default {
        computed: {
            errors() {
                return this.form.errors;
            }
        },
        data() {
            return {
                form: new Form({
                    name: null,
                    city: null,
                    age: null
                }),

                endpoint: '/api/persons',
            }
        },

        methods: {
            /**
             * Store person in db.
             *
             * @return {void}
             */
            create() {
                this.form.post(this.endpoint)
                    .then(response => {
                        this.form.reset();
                        this.$emit('create-person')
                    });
            },

            /**
             * Clear errors.
             *
             * @return {void}
             */
            clear() {
                this.form.errors.clear();
            }
        },
    }
</script>
