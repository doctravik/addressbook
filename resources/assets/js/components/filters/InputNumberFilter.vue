<script>
    import InputFilter from './InputFilter';

    export default {
        methods: {
            /**
             * @param {string} value
             * @return {string}
             */
            normalize(value) {
                return value.replace(/[^\d]+/gi, '');
            }
        },

        mixins: [ InputFilter ]
    };
</script>
