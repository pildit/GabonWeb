import Routes from "./_config/Routes";

export default {

    build: (name, params = {}) => {
        if(!name) {
            throw new Error("Name property not found.");
        }

        let path = name.split('.').reduce((memo, item) => {
            return memo[item]
        }, Routes);

        return Object.keys(params).reduce((memo, item) => {
            memo = memo.replace(`{${item}}`, params[item]);
            return memo;
        }, path);
    }

}
