class Base {
    static render(selector, options = {})
    {
        let components = this.getComponents();

        return components[selector](`#${selector}`, options);
    }
}

export default Base;
