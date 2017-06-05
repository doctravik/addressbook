<template>
    <div class="panel panel-default">
        <div class="panel-heading">Personal info</div>
        <div class="panel-body">
            <form role="form" @submit.prevent="update">

                <div class="form-group" :class="{'has-error': errors.has('name')}">
                    <label class="control-label">Name</label>
                    <input type="text" class="form-control" name="name"
                        v-model="form.name" required autofocus>
                    <span class="help-block" v-if="errors.has('name')">
                        <strong v-text="errors.get('name')"></strong>
                    </span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('age')}">
                    <label class="control-label">Age</label>
                    <input type="text" class="form-control" name="age"
                        v-model="form.age" required>
                    <span class="help-block" v-if="errors.has('age')">
                        <strong v-text="errors.get('age')"></strong>
                    </span>
                </div>

                <div class="form-group" :class="{'has-error': errors.has('city')}">
                    <label class="control-label">City</label>
                    <input type="text" class="form-control" name="City"
                        v-model="form.city" required>
                    <span class="help-block" v-if="errors.has('city')">
                        <strong v-text="errors.get('city')"></strong>
                    </span>
                </div>

                <button type="submit" class="btn btn-info">Update</button>
                <button class="btn btn-default" v-if="errors.any()" @click="clear">
                    Reset
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from './../../helpers/Form.js';

    export default {
        props: ['person'],

        computed: {
            errors() {
                return this.form.errors;
            }
        },

        data() {
            return {
                form: new Form({
                    age: this.person.age,
                    name: this.person.name,
                    city: this.person.city,
                }),

                endpoint: `/api/persons/${this.person.id}`,
            }
        },

        methods: {
            /**
             * Update person in db.
             *
             * @return {void}
             */
            update() {
                this.form.put(this.endpoint)
                    .then(response => {
                        eventDispatcher.$emit('update-person', response);
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
        }
    }
</script>
