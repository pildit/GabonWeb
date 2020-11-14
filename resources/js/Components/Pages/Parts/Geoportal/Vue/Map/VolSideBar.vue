<template>
  <div>
    <div class="options"></div>
    <!-- Content of the menu -->
    <div id="menu" v-bind:style="{ height: window.height + 'px' }">
      <h1>Options</h1>
      <div class="data"></div>

      <hr />
      <rcp-checkbox
        v-model="viewActiveTransports"
        text="View active transports"
      ></rcp-checkbox>
      <hr />
      <rcp-checkbox
        v-model="checkPlateNumber"
        text="Check plate number"
      ></rcp-checkbox>

      <input
        v-if="checkPlateNumber"
        v-model="plateNumber"
        placeholder="ex: PH 01 UNU"
      />
      <rcp-button v-if="checkPlateNumber" v-on:click="onCheckPlateNumber">
        Check
      </rcp-button>
      <rcp-alert-box v-if="checkPlateNumber && checkPlateNumberError">
        Invalid plate number
      </rcp-alert-box>
      <hr v-if="checkPlateNumber" />

      <rcp-checkbox
        v-model="checkAnnualAllowableCut"
        text="Check Annual Allowable cut"
      ></rcp-checkbox>
      <rcp-checkbox
        v-model="checkTransportPermit"
        text="Check Transport Permit"
      ></rcp-checkbox>
      <hr />
      <rcp-checkbox v-model="viewParcels" text="View Parcels"></rcp-checkbox>
      <rcp-checkbox
        v-model="viewConcessions"
        text="View Concessions"
      ></rcp-checkbox>
      <rcp-checkbox v-model="viewUFA" text="View UFA"></rcp-checkbox>
      <rcp-checkbox v-model="viewUFG" text="View UFG"></rcp-checkbox>
      <rcp-checkbox v-model="viewAAC" text="View AAC"></rcp-checkbox>

    </div>
  </div>
</template>

<script>
import olExtOverlay from "ol-ext/control/Overlay";
import olExtToggle from "ol-ext/control/Toggle";

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

import "pretty-checkbox/src/pretty-checkbox.scss";

export default {
  name: "VolSideBar",

  data() {
    return {
      range: {
        start: new Date(2020, 9, 12),
        end: new Date(2020, 9, 16),
      },
      viewActiveTransports: false,
      
      plateNumber: '',
      checkPlateNumber: false,
      checkPlateNumberError: false,

      checkAnnualAllowableCut: false,
      checkTransportPermit: false,
      viewParcels: false,
      viewConcessions: false,
      viewUFA: false,
      viewUFG: false,
      viewAAC: false,

      searchText: 0,
      message: "",
      checked: false,
      date: new Date(),
      timezone: "",
      mode: "date",
      count: 0,
      window: {
        width: 0,
        height: 0,
      },
    };
  },

  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },

  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
  },

  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },

    ...mapActions({
      setMap: "geoportal/setMap",
    }),

    onCheckPlateNumber() {
      if (this.plateNumber.length > 2) {
        this.checkPlateNumberError = false;

      }
      else {
        this.checkPlateNumberError = true;
      }
    },
  },

  mounted() {
    window.addEventListener("resize", () => {
      this.windowHeight = window.innerHeight;
    });

    var menu = new olExtOverlay({
      closeBox: true,
      className: "menu",
      content: $("#menu").get(0),
    });

    this.map.addControl(menu);

    // A toggle control to show/hide the menu
    var t = new olExtToggle({
      html: '<i class="fa fa-bars" ></i>',
      className: "menu",
      title: "Menu",
      onToggle: function () {
        menu.toggle();
      },
    });

    this.map.addControl(t);

    this.setMap(this.map);
    console.log("Sidebar Map instance: ", this.map);
  },
};
</script>


<style>
.ol-overlay.menu {
  width: 30%;
  background: #fff;
  color: #333;
  box-shadow: 0px 0px 5px #000;
  padding: 0.5em;
  -webkit-transition: all 0.25s;
  transition: all 0.25s;
}
/* style the close box */
.ol-overlay.menu .ol-closebox {
  color: #369;
  left: 1em;
  top: 0.5em;
}
.ol-overlay.menu .ol-closebox:before {
  content: "\f0c9";
  font-family: FontAwesome;
}
#menu {
  padding-top: 1.5em;
  font-size: 0.9em;
  overflow-x: scroll;
}
/* menu button */
.ol-control.menu {
  top: 0.5em;
  left: 0.5em;
}
.ol-control.menu i {
  color: #fff;
  transition: all 0.5s ease-in-out;
}
.ol-zoom {
  left: auto;
  right: 0.5em;
}
.ol-rotate {
  right: 3em;
}
.ol-touch .ol-rotate {
  right: 3.5em;
}
/**/
.ol-overlay img {
  max-width: 90%;
}
.ol-overlay.slide-up {
  transform: translateY(100%);
  -webkit-transform: translateY(100%);
}
.ol-overlay.slide-down {
  -webkit-transform: translateY(-100%);
  transform: translateY(-100%);
}
.ol-overlay.slide-left {
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);
}
.ol-overlay.slide-right {
  -webkit-transform: translateX(100%);
  transform: translateX(100%);
}
.data,
.data p {
  margin: 0;
  text-align: center;
  font-size: 0.9em;
}
</style>