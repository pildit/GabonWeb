<template>
  <div id="sidebar" class="leaflet-sidebar collapsed">
    <!-- nav tabs -->
    <div class="leaflet-sidebar-tabs">
      <!-- top aligned tabs -->
      <ul role="tablist">
        <li>
          <a href="#home" role="tab"><i class="fa fa-bars active"></i></a>
        </li>
      </ul>
    </div>

    <!-- panel content -->
    <div class="leaflet-sidebar-content">
      <div class="leaflet-sidebar-pane" id="home">
        <h1 class="leaflet-sidebar-header">
          Options
          <span class="leaflet-sidebar-close"
            ><i class="fa fa-caret-left"></i
          ></span>
        </h1>

        <div class="data"></div>

        <p />
        <rcp-checkbox
          v-model="viewActiveTransports"
          text="View active transports"
        ></rcp-checkbox>
        <hr />

        <!-- Radio buttons -->
        <div class="form-check">
          
          <!-- Check plate number -->
          <input
            id="checkPlateNumber"
            class="form-check-input"
            type="radio"
            value="checkPlateNumber"
            v-model="checkPicked"
            v-on:click="onCheckNone"
          />
          <label class="form-check-label" for="checkPlateNumber"
            ><h6 class="text-dark">Check plate number</h6></label
          >
          <br />
          <div class="row">
            <div class="col-lg-12">
              <div class="input-group input-group-md">
                <input
                  class="form-control"
                  v-if="checkPicked == 'checkPlateNumber'"
                  v-model="plateNumber"
                  placeholder="ex: PH 01 UNU"
                />
                <span class="input-group-btn input-group-md">
                  <rcp-button
                    type="submit"
                    v-if="checkPicked == 'checkPlateNumber'"
                    v-on:click="onCheckPlateNumber"
                  >
                    Search
                  </rcp-button>
                </span>
              </div>
            </div>
          </div>

          <rcp-alert-box
            v-if="checkPicked == 'checkPlateNumber' && checkPlateNumberError"
          >
            Invalid plate number
          </rcp-alert-box>
          <p v-if="checkPicked == 'checkPlateNumber'"></p>

          <!-- Select date interval -->
          <form>
            <v-date-picker
              v-if="checkPicked == 'checkPlateNumber'"
              is-range
              v-model="checkPlateNumberRange"
              :popover="popover"
            >
              <template v-slot="{ inputValue, inputEvents }">
                <div class="form-group">
                  <label for="startDate">From</label>
                  <input
                    id="startDate"
                    class="form-control"
                    :value="inputValue.start"
                    v-on="inputEvents.start"
                  />
                </div>
                <div class="form-group">
                  <label for="endDate">To</label>
                  <input
                    id="endDate"
                    class="form-control"
                    :value="inputValue.end"
                    v-on="inputEvents.end"
                  />
                </div>
              </template>
            </v-date-picker>
          </form>

          <hr v-if="checkPicked == 'checkPlateNumber'" />

          <!-- Check Annual Allowable cut -->

          <input
            id="checkAnnualAllowableCut"
            class="form-check-input"
            type="radio"
            value="checkAnnualAllowableCut"
            v-model="checkPicked"
            v-on:click="onCheckNone"
          />
          <label class="form-check-label" for="checkAnnualAllowableCut"
            ><h6 class="text-dark">Check Annual Allowable cut</h6></label
          >
          <br />

          <div class="row">
            <div class="col-lg-12">
              <div class="input-group input-group-md">
                <input
                  class="form-control"
                  v-if="checkPicked == 'checkAnnualAllowableCut'"
                  v-model="annualAllowableCut"
                  placeholder="ACC name/id"
                />
                <span class="input-group-btn input-group-md">
                  <rcp-button
                    v-if="checkPicked == 'checkAnnualAllowableCut'"
                    v-on:click="onCheckAnnualAllowableCut"
                  >
                    Search
                  </rcp-button>
                </span>
              </div>
            </div>
            <div
              class="col-lg-12 ml-2"
              v-if="checkPicked == 'checkAnnualAllowableCut'"
            >
              <small class="form-text text-muted"
                >ACC - Annual Allowable Cut.</small
              >
            </div>
          </div>

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
            id="checkTransportPermit"
            class="form-check-input"
            type="radio"
            value="checkTransportPermit"
            v-model="checkPicked"
            v-on:click="onCheckNone"
          />
          <label class="form-check-label" for="checkTransportPermit"
            ><h6 class="text-dark">Check Transport Permit</h6></label
          >
          <br v-if="checkPicked == 'checkTransportPermit'" />

          <div class="row">
            <div class="col-lg-12">
              <div class="input-group input-group-md">
                <input
                  class="form-control"
                  v-if="checkPicked == 'checkTransportPermit'"
                  v-model="transportPermitId"
                  placeholder="Transport permit ID"
                />
                <span class="input-group-btn input-group-md">
                  <rcp-button
                    v-if="checkPicked == 'checkTransportPermit'"
                    v-on:click="onCheckTransportPermitId"
                  >
                    Search by id
                  </rcp-button>
                </span>
              </div>
            </div>
          </div>

          <rcp-alert-box
            v-if="
              checkPicked == 'checkTransportPermit' &&
              checkTransportPermitIdError
            "
          >
            Invalid transport permit id
          </rcp-alert-box>
          <p v-if="checkPicked == 'checkTransportPermit'" />

          <v-date-picker
            v-if="checkPicked == 'checkTransportPermit'"
            v-model="transportPermitDate"
            :popover="popover"
          >
            <template v-slot="{ inputValue, inputEvents }">
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group input-group-md">
                    <input
                      class="form-control"
                      :value="inputValue"
                      v-on="inputEvents"
                    />

                    <span class="input-group-btn input-group-md">
                      <rcp-button
                        v-if="checkPicked == 'checkTransportPermit'"
                        v-on:click="onCheckTransportPermitDate"
                      >
                        Search by date
                      </rcp-button>
                    </span>
                  </div>
                </div>
              </div>
            </template>
          </v-date-picker>

          <rcp-alert-box
            v-if="
              checkPicked == 'checkTransportPermit' &&
              checkTransportPermitDateError
            "
          >
            Invalid transport permit date
          </rcp-alert-box>
          <vue-range-slider
            style="margin-top: 50px"
            v-if="checkPicked == 'checkTransportPermit'"
            v-model="transportPermitHourInterval"
            :min="transportPermitHourMin"
            :max="transportPermitHourMax"
            :formatter="transportPermitHourFormatter"
            :tooltip-merge="false"
            :enable-cross="false"
          ></vue-range-slider>

          <br />
          <hr />
        </div>

        <!-- View -->
        <rcp-checkbox
          v-model="viewParcels"
          v-on:click="onViewParcelClick"
          text="View Parcels"
        ></rcp-checkbox>
        <rcp-checkbox
          v-model="viewConcessions"
          v-on:click="onViewConcessionsClick"
          text="View Concessions"
        ></rcp-checkbox>
        <rcp-checkbox
          v-model="viewUFA"
          v-on:click="onViewUFA"
          text="View UFA"
        ></rcp-checkbox>
        <rcp-checkbox
          v-model="viewUFG"
          v-on:click="onViewUFG"
          text="View UFG"
        ></rcp-checkbox>
        <rcp-checkbox
          v-model="viewAAC"
          v-on:click="onViewAAC"
          text="View AAC"
        ></rcp-checkbox>
        <rcp-checkbox
          v-model="viewTrees"
          v-on:click="onViewTrees"
          text="View Trees"
        ></rcp-checkbox>
      </div>
    </div>
  </div>
</template>

<script>
import { MarkerClusterGroup } from "leaflet.markercluster";
import { findRealParent, propsBinder } from "vue2-leaflet";
import { DomEvent } from "leaflet";
import "leaflet-sidebar-v2";
import * as L from "leaflet";

import "pretty-checkbox/src/pretty-checkbox.scss";
import "vue-range-component/dist/vue-range-slider.css";

export default {
  props: ["map"],
  data() {
    return {
      popover: { visibility: 'focus' },

      transportPermitHourInterval: [10, 13],
      transportPermitHourMin: 0,
      transportPermitHourMax: 24,
      transportPermitHourFormatter: (value) => {
        if (value === 24) {
          return "23:59";
        }
        return `${value}:00`;
      },

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

      /* MENU */
      menu: null,
      toggaleMenu: null,
    };
  },
  mounted() {},
  watch: {
    map: function (newVal, oldVal) {
      if (newVal != null) {
        var sidebar = L.control.sidebar({ container: "sidebar" }).addTo(newVal);
      }
    },
  },
  methods: {
    onCheckNone() {
      if (this.checkPicked !== "none") {
        this.$emit("onCheckNone");
        this.checkPicked = "none";
      }
    },

    onCheckPlateNumber() {
      if (this.plateNumber.length >= 2) {
        this.checkPlateNumberError = false;
      } else {
        this.checkPlateNumberError = true;
      }
    },

    onCheckAnnualAllowableCut() {
      if (this.annualAllowableCut.length >= 2) {
        this.checkAnnualAllowableCutError = false;

        this.$emit("onCheckAAC", this.annualAllowableCut);
      } else {
        this.checkAnnualAllowableCutError = true;
      }
    },

    onCheckTransportPermitId() {
      if (this.transportPermitId.length >= 2) {
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

    onViewParcelClick() {
      this.$emit("onViewParcels", !this.viewParcels);
    },

    onViewConcessionsClick() {
      this.$emit("onViewConcessions", !this.viewConcessions);
    },

    onViewUFA() {
      this.$emit("onViewUFA", !this.viewUFA);
    },

    onViewUFG() {
      this.$emit("onViewUFG", !this.viewUFG);
    },

    onViewAAC() {
      this.$emit("onViewAAC", !this.viewAAC);
    },

    onViewTrees() {
      this.$emit("onViewTrees", !this.viewTrees);
    },
  },
};
</script>

<style scoped>
.leaflet-sidebar {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 100%;
  overflow: hidden;
  z-index: 2000;
}

.leaflet-sidebar.collapsed {
  width: 40px;
  height: 40px;
}
@media (min-width: 768px) {
  .leaflet-sidebar {
    top: 10px;
    bottom: 10px;
    transition: width 500ms;
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .leaflet-sidebar {
    width: 305px;
    max-width: 305px;
  }
}
@media (min-width: 992px) and (max-width: 1199px) {
  .leaflet-sidebar {
    width: 400px;
    max-width: 400px;
  }
}
@media (min-width: 1200px) {
  .leaflet-sidebar {
    width: 460px;
    max-width: 460px;
  }
}

.leaflet-sidebar-left {
  left: 0;
}
@media (min-width: 768px) {
  .leaflet-sidebar-left {
    left: 10px;
  }
}

.leaflet-sidebar-right {
  right: 0;
}
@media (min-width: 768px) {
  .leaflet-sidebar-right {
    right: 10px;
  }
}

.leaflet-sidebar-tabs {
  top: 0;
  bottom: 0;
  height: 100%;
  background-color: #fff;
}
.leaflet-sidebar-left .leaflet-sidebar-tabs {
  left: 0;
}
.leaflet-sidebar-right .leaflet-sidebar-tabs {
  right: 0;
}
.leaflet-sidebar-tabs,
.leaflet-sidebar-tabs > ul {
  position: absolute;
  width: 40px;
  margin: 0;
  padding: 0;
  list-style-type: none;
}
.leaflet-sidebar-tabs > li,
.leaflet-sidebar-tabs > ul > li {
  width: 100%;
  height: 40px;
  color: #333;
  font-size: 12pt;
  overflow: hidden;
  transition: all 80ms;
}
.leaflet-sidebar-tabs > li:hover,
.leaflet-sidebar-tabs > ul > li:hover {
  color: #000;
  background-color: #eee;
}
.leaflet-sidebar-tabs > li.active,
.leaflet-sidebar-tabs > ul > li.active {
  color: #fff;
  background-color: #259d36;
}
.leaflet-sidebar-tabs > li.disabled,
.leaflet-sidebar-tabs > ul > li.disabled {
  color: rgba(51, 51, 51, 0.4);
}
.leaflet-sidebar-tabs > li.disabled:hover,
.leaflet-sidebar-tabs > ul > li.disabled:hover {
  background: transparent;
}
.leaflet-sidebar-tabs > li.disabled > a,
.leaflet-sidebar-tabs > ul > li.disabled > a {
  cursor: default;
}
.leaflet-sidebar-tabs > li > a,
.leaflet-sidebar-tabs > ul > li > a {
  display: block;
  width: 100%;
  height: 100%;
  line-height: 40px;
  color: inherit;
  text-decoration: none;
  text-align: center;
  cursor: pointer;
}
.leaflet-sidebar-tabs > ul + ul {
  bottom: 0;
}

.leaflet-sidebar-content {
  position: absolute;
  top: 0;
  bottom: 0;
  background-color: rgba(255, 255, 255, 0.95);
  overflow-x: hidden;
  overflow-y: auto;
}
.leaflet-sidebar-left .leaflet-sidebar-content {
  left: 40px;
  right: 0;
}
.leaflet-sidebar-right .leaflet-sidebar-content {
  left: 0;
  right: 40px;
}
.leaflet-sidebar.collapsed > .leaflet-sidebar-content {
  overflow-y: hidden;
}

.collapsed > .leaflet-sidebar-content {
  overflow-y: hidden;
}

.leaflet-sidebar-pane {
  display: none;
  left: 0;
  right: 0;
  box-sizing: border-box;
  padding: 10px 20px;
}
.leaflet-sidebar-pane.active {
  display: block;
}
@media (min-width: 768px) and (max-width: 991px) {
  .leaflet-sidebar-pane {
    min-width: 265px;
  }
}
@media (min-width: 992px) and (max-width: 1199px) {
  .leaflet-sidebar-pane {
    min-width: 350px;
  }
}
@media (min-width: 1200px) {
  .leaflet-sidebar-pane {
    min-width: 420px;
  }
}

.leaflet-sidebar-header {
  margin: -10px -20px 0;
  height: 40px;
  padding: 0 20px;
  line-height: 40px;
  font-size: 14.4pt;
  color: #fff;
  background-color: #259d36;
}
.leaflet-sidebar-right .leaflet-sidebar-header {
  padding-left: 40px;
}

.leaflet-sidebar-close {
  position: absolute;
  top: 0;
  width: 40px;
  height: 40px;
  text-align: center;
  cursor: pointer;
}
.leaflet-sidebar-left .leaflet-sidebar-close {
  right: 0;
}
.leaflet-sidebar-right .leaflet-sidebar-close {
  left: 0;
}

.leaflet-sidebar {
  box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65);
}
@media (min-width: 768px) {
  .leaflet-sidebar {
    border-radius: 4px;
  }
  .leaflet-sidebar.leaflet-touch {
    border: 2px solid rgba(0, 0, 0, 0.2);
  }
}

.leaflet-sidebar-left.leaflet-touch {
  box-shadow: none;
  border-right: 2px solid rgba(0, 0, 0, 0.2);
}

@media (min-width: 768px) {
  .leaflet-sidebar-left ~ .leaflet-control-container .leaflet-left {
    transition: left 500ms;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .leaflet-sidebar-left ~ .leaflet-control-container .leaflet-left {
    left: 315px;
  }
}

@media (min-width: 992px) and (max-width: 1199px) {
  .leaflet-sidebar-left ~ .leaflet-control-container .leaflet-left {
    left: 400px;
  }
}

@media (min-width: 1200px) {
  .leaflet-sidebar-left ~ .leaflet-control-container .leaflet-left {
    left: 470px;
  }
}

.leaflet-sidebar-left.collapsed ~ .leaflet-control-container .leaflet-left {
  left: 50px;
}

.leaflet-sidebar-right.leaflet-touch {
  box-shadow: none;
  border-left: 2px solid rgba(0, 0, 0, 0.2);
}

@media (min-width: 768px) {
  .leaflet-sidebar-right ~ .leaflet-control-container .leaflet-right {
    transition: right 500ms;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .leaflet-sidebar-right ~ .leaflet-control-container .leaflet-right {
    right: 315px;
  }
}

@media (min-width: 992px) and (max-width: 1199px) {
  .leaflet-sidebar-right ~ .leaflet-control-container .leaflet-right {
    right: 400px;
  }
}

@media (min-width: 1200px) {
  .leaflet-sidebar-right ~ .leaflet-control-container .leaflet-right {
    right: 470px;
  }
}

.leaflet-sidebar-right.collapsed ~ .leaflet-control-container .leaflet-right {
  right: 50px;
}
html,
body {
  height: 100%;
  margin: 0;
}
</style>