<template>
  <li :class="isFolder ? 'nav-item dropdown' : 'nav-item'" :role="isFolder ? false : 'presentation'">
    <a  :href="isFolder ? '#' : model.path"
        :id="'menu_' +  isFolder ? model.menu : model.submenu "
        :class="isFolder? 'nav-link dropdown-toggle' : 'nav-link'"
        :data-toggle="isFolder ? 'dropdown' : false"
        role="button"
        aria-haspopup="true"
        aria-expanded="false">{{ model.menu ? translate(model.menu) : translate(model.submenu) }}</a>
  <ul class="nav-item dropdown-menu dropdown-default">
    <menu-item
        v-for="(model, index) in model.children"
        :key="index"
        :model="model">
    </menu-item>
  </ul>
  </li>
</template>
<script>
import Translation from "components/Mixins/Translation";
export default {
  mixins: [Translation],
  name: 'menu-item',
  props: {
    model: Object
  },
  data: function() {
    return {
      open: false
    };
  },
  computed: {
    isFolder: function() {
      return this.model.children && this.model.children.length;
    }
  },
  methods: {
      toggle: function() {
      if (this.isFolder) {
        this.open = !this.open;
      }
    },
  }
}
</script>
