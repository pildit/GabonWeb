
export default {
    methods: {
        translate(key) {
            this.$validator.localize(this.$store.getters.lang);
            return this.$store.getters.translations[key] || `*${key}*`;
        }
    }
}
