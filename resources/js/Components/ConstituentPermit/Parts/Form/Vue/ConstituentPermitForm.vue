<template>
    <div class="card" ref="cp_form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('constituent_permit_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="PermitType"
                                v-validate="'required'"
                                v-model="form.PermitType"
                                :options="permitTypeList.data"
                                :placeholder="translate('permit_type_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="permitTypeList.isLoading"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                                @search-change="asyncFindPermitType"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }} ({{option.Abbreviation}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }} ({{option.Abbreviation}})</template>
                            </multiselect>
                            <div v-show="errors.has('PermitType')" class="invalid-feedback">{{ errors.first('PermitType') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="PermitNumber" name="PermitNumber" class="form-control"
                                   v-model="form.PermitNumber"
                                   :data-vv-as="translate('permit_number_constituent_form')"
                                   v-validate="'required'"
                            >
                            <label for="PermitNumber" :class="{'active': form.PermitNumber}">{{translate('permit_number_constituent_form')}}</label>
                            <div v-show="errors.has('PermitNumber')" class="invalid-feedback">{{ errors.first('PermitNumber') }}</div>
                        </div>
                    </div>
                </div>
                <div class="md-form">
                    <input type="text" name="Geometry" id="Geometry" class="form-control" @change="onGeometryChange" v-model="form.Geometry" v-validate="'required'">
                    <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
                    <div v-show="errors.has('Geometry')" class="invalid-feedback">{{ errors.first('Geometry') }}</div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="Concession"
                                v-validate="'required'"
                                v-model="form.Concession"
                                :options="concessionList.data"
                                :placeholder="translate('concession_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="concessionList.isLoading"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                                @search-change="asyncFindConcession"
                            ></multiselect>
                            <div v-show="errors.has('Concession')" class="invalid-feedback">{{ errors.first('Concession') }}</div>
                        </div>
                    </div>
                </div>

                <div class="form-row float-right text-white">
                    <button @click="save()" class="btn btn-info z-depth-0 my-4" :disabled="saveLoading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saveLoading"></span>
                        {{ translate('save') }}
                    </button>
                    <a class="btn btn-warning z-depth-0 my-4" :href="indexRoute()">{{translate('cancel_button')}}</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import PermitType from "components/PermitType/PermitType";
import Concession from "components/Concession/Concession";
import ConstituentPermit from "components/ConstituentPermit/ConstituentPermit";
import Notification from "components/Common/Notifications/Notification";
import Multiselect from "vue-multiselect";
import _ from "lodash";

import { EventBus } from "components/EventBus/EventBus";
ConstituentPermit
export default {

    props: ['constituentPermitProp', 'endpointCreate', 'endpointEdit'],

    components: { Multiselect },

    data() {
      return {
          form: {},
          saveLoading: false,
          permitTypeList: {
              data: [],
              isLoading: false
          },
          concessionList: {
              data: [],
              isLoading: false,
              limit: 50
          },
      }
    },

    computed: {
        isCreatedFormType() {
            return _.isEmpty(this.constituentPermitProp);
        }
    },

    created() {
        this.asyncFindPermitType('');
        this.asyncFindConcession();
    },

    methods: {
        indexRoute() {
            return ConstituentPermit.buildRoute('constituent_permits.index');
        },
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    this.saveLoading = true;
                    let promise = this.isCreatedFormType ? this.create : this.update
                    return promise(this.form).finally(() => this.saveLoading = false);
                }
            })
        },

        create(data) {
            data = ConstituentPermit.buildForm(data);
            return ConstituentPermit.add(data).then((data) => {
                Notification.success(this.translate('constituent_permit'), data.message);
                window.location.href = this.indexRoute();
            })
        },

        update(data) {
            data = ConstituentPermit.buildForm(data);
            return ConstituentPermit.update(this.constituentPermitProp.Id, data).then((data) => {
                Notification.success(this.translate('constituent_permit'), data.message);
                window.location.href = this.indexRoute();
            })
        },
        asyncFindConcession(query = '') {
            this.concessionList.isLoading = true;
            Concession.listSearch(query, this.concessionList.limit).then((response) => {
                this.concessionList.data = response.data;
                this.concessionList.isLoading = false;
            })
        },
        asyncFindPermitType(query) {
            this.permitTypeList.isLoading = true;
            PermitType.listSearch(query, this.permitTypeList.limit).then((response) => {
                this.permitTypeList.data= response.data;
                this.permitTypeList.isLoading = false;
                if(this.form.permit_type) {
                    this.form.PermitType = this.permitTypeList.data.find((x) => x['Id'] == this.form.permit_type.Id);
                }
            })
        },

        onGeometryChange(value) {
            if (this.endpointEdit) {
                EventBus.$emit(this.endpointEdit, this.form.Geometry);
            }
        },
    },

    watch: {
        constituentPermitProp(value) {
            if(value) {
                this.form = _.merge(this.form, value);
                this.form.Geometry = value.geometry_as_text;
                this.form.PermitType = this.permitTypeList.data.find((x) => x.Id == value.PermitType);
                this.form.Concession = this.concessionList.data.find((x) => x.Id == value.Concession);

                if (this.endpointEdit) {
                    EventBus.$emit(this.endpointEdit, value.geometry_as_text);
                }

                this.$forceUpdate();
            }
        }
    },

    mounted() {
        EventBus.$on(this.endpointCreate, (data) => {
            this.form.Geometry = data;
            this.$forceUpdate();
        });
    },
}
</script>

<style scoped>

</style>
