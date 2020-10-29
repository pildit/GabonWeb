
export default {
    methods: {
        translate(key) {
            return this.$store.getters.translations[key] || `*${key}*`;
        }
    }
}
