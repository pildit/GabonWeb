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

      <!-- Check None -->
      <input type="radio" id="none" value="none" v-model="checkPicked" />
      <p-radio
        color="success-o"
        name="none"
        value="none"
        v-model="checkPicked"
      ></p-radio>
      <label for="none">None</label>
      <br />

      <!-- Check plate number -->
      <input
        type="radio"
        id="checkPlateNumber"
        value="checkPlateNumber"
        v-model="checkPicked"
      />
      <p-radio
        color="success-o"
        name="checkPlateNumber"
        value="checkPlateNumber"
        v-model="checkPicked"
      ></p-radio>
      <label for="checkPlateNumber">Check plate number</label>
      <br />
      <input
        v-if="checkPicked == 'checkPlateNumber'"
        v-model="plateNumber"
        placeholder="ex: PH 01 UNU"
      />
      <rcp-button
        v-if="checkPicked == 'checkPlateNumber'"
        v-on:click="onCheckPlateNumber"
      >
        Search
      </rcp-button>
      <rcp-alert-box
        v-if="checkPicked == 'checkPlateNumber' && checkPlateNumberError"
      >
        Invalid plate number
      </rcp-alert-box>
      <p v-if="checkPicked == 'checkPlateNumber'"></p>
      <v-date-picker
        v-if="checkPicked == 'checkPlateNumber'"
        is-range
        v-model="checkPlateNumberRange"
      >
        <template v-slot="{ inputValue, inputEvents }">
          <div class="flex justify-center items-center">
            <input
              :value="inputValue.start"
              v-on="inputEvents.start"
              class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
            />
            -
            <input
              :value="inputValue.end"
              v-on="inputEvents.end"
              class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
            />
          </div>
        </template>
      </v-date-picker>
      <hr v-if="checkPicked == 'checkPlateNumber'" />

      <!-- Check Annual Allowable cut -->
      <input
        type="radio"
        id="checkAnnualAllowableCut"
        value="checkAnnualAllowableCut"
        v-model="checkPicked"
      />
      <p-radio
        color="success-o"
        name="checkAnnualAllowableCut"
        value="checkAnnualAllowableCut"
        v-model="checkPicked"
      ></p-radio>
      <label for="checkAnnualAllowableCut">Check Annual Allowable cut</label>
      <br />
      <input
        v-if="checkPicked == 'checkAnnualAllowableCut'"
        v-model="annualAllowableCut"
        placeholder="Annual allowable cut name/id"
      />
      <rcp-button
        v-if="checkPicked == 'checkAnnualAllowableCut'"
        v-on:click="onCheckAnnualAllowableCut"
      >
        Search
      </rcp-button>
      <rcp-alert-box
        v-if="
          checkPicked == 'checkAnnualAllowableCut' &&
          checkAnnualAllowableCutError
        "
      >
        Invalid annual allowable cut name/id
      </rcp-alert-box>
      <hr v-if="checkPicked == 'checkAnnualAllowableCut'" />

      <!-- Check Transport Permit -->
      <input
        type="radio"
        id="checkTransportPermit"
        value="checkTransportPermit"
        v-model="checkPicked"
      />
      <p-radio
        color="success-o"
        name="checkTransportPermit"
        value="checkTransportPermit"
        v-model="checkPicked"
      ></p-radio>
      <label for="checkTransportPermit">Check Transport Permit</label>
      <br v-if="checkPicked == 'checkTransportPermit'" />

      <input
        v-if="checkPicked == 'checkTransportPermit'"
        v-model="transportPermitId"
        placeholder="Transport permit ID"
      />
      <rcp-button
        v-if="checkPicked == 'checkTransportPermit'"
        v-on:click="onCheckTransportPermitId"
      >
        Search by id
      </rcp-button>
      <rcp-alert-box
        v-if="
          checkPicked == 'checkTransportPermit' && checkTransportPermitIdError
        "
      >
        Invalid transport permit id
      </rcp-alert-box>
      <p v-if="checkPicked == 'checkTransportPermit'" />

      <v-date-picker
        v-if="checkPicked == 'checkTransportPermit'"
        v-model="transportPermitDate"
        mode="date"
      >
        <template v-slot="{ inputValue, inputEvents }">
          <input
            class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
            :value="inputValue"
            v-on="inputEvents"
          />
        </template>
      </v-date-picker>
      <rcp-button
        v-if="checkPicked == 'checkTransportPermit'"
        v-on:click="onCheckTransportPermitDate"
      >
        Search by date
      </rcp-button>
      <rcp-alert-box
        v-if="
          checkPicked == 'checkTransportPermit' && checkTransportPermitDateError
        "
      >
        Invalid transport permit date
      </rcp-alert-box>

      <br />
      <hr />

      <!-- View -->
      <rcp-checkbox v-model="viewParcels" text="View Parcels"></rcp-checkbox>
      <rcp-checkbox
        v-model="viewConcessions"
        text="View Concessions"
      ></rcp-checkbox>
      <rcp-checkbox v-model="viewUFA" text="View UFA"></rcp-checkbox>
      <rcp-checkbox v-model="viewUFG" text="View UFG"></rcp-checkbox>
      <rcp-checkbox v-model="viewAAC" text="View AAC"></rcp-checkbox>
      <rcp-checkbox v-model="viewTrees" text="View Trees"></rcp-checkbox>

      <button v-on:click="onTransmitAValue">{{clusterButtonText}}</button>
      <span>Picked: {{ checkPicked }}</span>
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
      clusterButtonText: 'Show Clusters', 
      checkPicked: "",

      range: {
        start: new Date(2020, 9, 12),
        end: new Date(2020, 9, 16),
      },
      viewActiveTransports: false,

      plateNumber: "",
      checkPlateNumber: false,
      checkPlateNumberError: false,
      checkPlateNumberRange: {
        start: new Date(2020, 9, 12),
        end: new Date(2020, 9, 16),
      },

      annualAllowableCut: "",
      checkAnnualAllowableCut: false,
      checkAnnualAllowableCutError: false,

      transportPermitId: "",
      transportPermitDate: new Date(),
      checkTransportPermit: false,
      checkTransportPermitIdError: false,
      checkTransportPermitDateError: false,

      viewParcels: false,
      viewConcessions: false,
      viewUFA: false,
      viewUFG: false,
      viewAAC: false,
      viewTrees: false,

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

      isTest: true,

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
      } else {
        this.checkPlateNumberError = true;
      }
    },

    onCheckAnnualAllowableCut() {
      if (this.annualAllowableCut.length > 2) {
        this.checkAnnualAllowableCutError = false;
      } else {
        this.checkAnnualAllowableCutError = true;
      }
    },

    onCheckTransportPermitId() {
      if (this.transportPermitId.length > 2) {
        this.checkTransportPermitIdError = false;
      } else {
        this.checkTransportPermitIdError = true;
      }
    },

    onCheckTransportPermitDate() {
      if (this.transportPermitDate) {
        this.checkTransportPermitDateError = false;
      } else {
        this.checkTransportPermitDateError = true;
      }
    },

    onTransmitAValue() {
      console.log("Button was pressed in VolSideBar");
      if (this.isTest) {
        this.clusterButtonText = "Hide Clusters";
        this.$emit("volSideCommandFunction", "Just a text for now");
      } else {
        this.clusterButtonText = "Show Clusters";
        this.$emit("volSideCommandFunction", "Just another text for now");
      }
      this.isTest = !this.isTest;
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