<script>
    import PersonAvatar from './../avatar/PersonAvatar';
    import UpdatePersonForm from './../forms/UpdatePersonForm';

    export default {
        props: ['personProp'],

        data() {
            return {
                person: this.personProp,
            }
        },

        /**
         * Mounted event of component
         */
        mounted() {
            eventDispatcher.$on('update-person', person => {
                this.person = person;
            })
        },

        components: { PersonAvatar, UpdatePersonForm }
    }
</script>
