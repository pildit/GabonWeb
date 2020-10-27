import store from "store/store";

class Base {

    static getTranslations()
    {
        return store.dispatch('$fetchTranslations').then(() => store.state.translations);
    }

    static render(selector, options = {})
    {
        let components = this.getComponents();

        return components[selector](`#${selector}`, options);
    }
}

export default Base;
