<template>
    <tr>
        <td>
            <img v-if="hasAvatar" :src="person.photo" alt="avatar">
            <img v-else src="http://placehold.it/100x100" alt="avatar">
        </td>
        <td>{{ person.name }}</td>
        <td>{{ person.age }}</td>
        <td>{{ person.city }}</td>
        <td>
            <div class="btn-group" role="group">
                <a :href="'/persons/' + person.id + '/edit'" class="btn btn-default">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <button type="button" class="btn btn-default" @click="deletePerson()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
    import Form from './../helpers/Form.js';

    export default {
        props: ['person'],

        computed: {
            hasAvatar() {
                return !! this.person.photo;
            },
        },

        data() {
            return {
                form: new Form(),
                endpoint: `/api/persons/${this.person.id}`
            }
        },

        methods: {
            /**
             * Remove person from db.
             *
             * @return {void}
             */
            deletePerson() {
                this.form.delete(this.endpoint)
                    .then(response => {
                        eventDispatcher.$emit('delete-person', this.person.id);
                    })
            },

        }
    }
</script>
