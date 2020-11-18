<template>
    <!-- Material form contact -->
    <div class="card" ref="development-unit-form">

        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('development_unit_create_form_title') }}</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

            <!-- Form -->
            <form class="text-center" style="color: #757575;" novalidate>

                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" class="form-control" v-model="form.Name">
                            <label for="Name">{{translate('development_unit_form_name')}}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Geometry" class="form-control" v-model="form.Geometry">
                            <label for="Geometry">{{translate('geometry_input_label')}}</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                v-model="form.Concession"
                                :options="concessionsList.data"
                                :placeholder="translate('concession_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="concessionsList.isLoading"
                                :allow-empty="false"
                                @search-change="asyncFindConcession"
                            ></multiselect>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                v-model="form.ProductType"
                                :options="productTypeList.data"
                                :placeholder="translate('resource_type_label')"
                                track-by="Id"
                                label="Name"
                                :allow-empty="false"
                            ></multiselect>
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div class="md-form mt-3">
                    <input type="text" id="materialContactFormName" class="form-control">
                    <label for="materialContactFormName">Name</label>
                </div>


                <div class="form-row float-right">
                    <button class="btn btn-outline-info z-depth-0 my-4" @click="save()">{{translate('save_button')}}</button>
                    <a class="btn btn-outline-warning z-depth-0 my-4" :href="indexRoute">{{translate('cancel_button')}}</a>
                </div>

            </form>
            <!-- Form -->

        </div>

    </div>
    <!-- Material form contact -->
</template>

<script>
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import Multiselect from 'vue-multiselect';

export default {

    components: {Multiselect},

    data() {
      return {
          form: {},
          concessionsList: {
              data: [],
              isLoading: false,
          },
          productTypeList: {
              data: [
                  {
                      Id: 1,
                      Name: "Log"
                  }
              ]
          }
      }
    },
    created() {
        this.form.ProductType = this.productTypeList.data[0];
    },

    methods: {
        indexRoute() {
            return DevelopmentUnit.buildRoute('development_units.index');
        },
        save() {

        },
        asyncFindConcession(query) {

        }
    }

}
</script>

<style scoped>

</style>
