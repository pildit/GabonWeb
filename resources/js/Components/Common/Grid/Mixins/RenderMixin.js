import _ from 'lodash';

export default {

  computed: {

    getCellValue() {
      let cell = (!this.columnProp.render || typeof this.columnProp != 'object')
        ? _.get(this.rowProp, this.keyProp)
        : this.columnProp.render(this.rowProp, this.index);

      if(this.columnProp.forceRender) {
        return  cell;
      }

      return ((typeof _.get(this.rowProp, this.keyProp) == 'undefined' ||  _.get(this.rowProp, this.keyProp) == null || _.get(this.rowProp,this.keyProp).length == 0) && this.keyProp != null)
        ? null
        : cell;

    },
  }

}
