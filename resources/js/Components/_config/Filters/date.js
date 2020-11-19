import moment from "moment";

export default (value) => {
    const date = moment(value);
    return date.format('YYYY-MM-DD');
}
