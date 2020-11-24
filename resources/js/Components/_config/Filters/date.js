import moment from "moment";

export default (value, label) => {
    if(!value) return label;
    const date = moment(value);
    return date.format('YYYY-MM-DD');
}
