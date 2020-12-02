<template>
    <div class="card" ref="parcel-form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('parcel_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="md-form mb-5">
                    <input type="text" v-model="form.Name" name="Name" class="form-control" v-validate="'required'">
                    <label data-error="wrong" data-success="right" for="name" :class="{'active': form.Name}">{{ translate('abbreviation') }}</label>
                    <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
                </div>
                <div class="md-form">
                    <input type="text" name="Geometry" id="Geometry" @change="onGeometryChange" class="form-control" v-model="form.Geometry" v-validate="'required'">
                    <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
                    <div v-show="errors.has('Geometry')" class="invalid-feedback">{{ errors.first('Geometry') }}</div>
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
import Parcel from "components/Parcel/Parcel";
import Notification from "components/Common/Notifications/Notification";
import { EventBus } from "components/EventBus/EventBus";
import _ from "lodash";

export default {

    props: ['parcelProp', 'endpointCreate', 'endpointEdit'],

    data() {
        return {
            form : {},
            saveLoading: false,
            isCreatedFormType: true
        }
    },

    mounted() {
        EventBus.$on(this.endpointCreate, (data) => {
            this.form.Geometry = data;
            this.$forceUpdate();
        });
    },

    methods: {
        indexRoute() {
            return Parcel.buildRoute('parcels.index');
        },
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    this.saveLoading = true;
                    let promise = this.isCreatedFormType ? this.create : this.update;
                    return promise(this.form).finally(() => this.saveLoading = false);
                }
            });
        },
        create() {
            return Parcel.add({
                Name: this.form.Name,
                Geometry: this.form.Geometry
            }).then((data) => {
                Notification.success(this.translate('parcels'), data.message);
                window.location.href = this.indexRoute();
            }).catch((error) => {
                if(error) {
                    this.$setErrorsFromResponse(error.data);
                }
            })
        },
        update() {
            return Parcel.update(this.parcelProp.Id, {
                Name: this.form.Name,
                Geometry: this.form.Geometry
            }).then((data) => {
                Notification.success(this.translate('parcels'), data.message);
                window.location.href = this.indexRoute();
            }).catch((error) => {
                console.log(error);
                if(error) {
                    this.$setErrorsFromResponse(error.data);
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
        parcelProp(value) {
            if(value) {
                this.isCreatedFormType = false;
                this.form.Name = value.Name;
                this.form.Geometry = value.geometry_as_text;
                if (this.endpointEdit) {
                    EventBus.$emit(this.endpointEdit, value.geometry_as_text);
                }
                this.$forceUpdate();
            }
        }
    }
}
</script>

<style scoped>

</style>
