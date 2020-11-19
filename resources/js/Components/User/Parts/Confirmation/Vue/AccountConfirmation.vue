<template>
    <div class="flex-center position-ref full-height">
        <div class="content full-width">
            <div class="card card-image rgba-green-strong">
                <div class="text-white text-center py-5 px-4">
                    <div class="spinner-border m-5" role="status" v-if="loading">
                        <span class="sr-only">{{ translate('loading') }}...</span>
                    </div>
                    <div v-else>
                        <h3 class="card-title h3-responsive pt-3 mb-5 font-bold">
                            <strong>{{message}}</strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import User from "components/User/User";

export default {
    props: ['tokenProp'],

    data() {
        return {
            loading: true,
            message: null,
        }
    },
    created() {
        User.verify({code: this.tokenProp}).then((data) => {
            this.message = data.message;
        }).catch((error) => {
            console.log(error.response);
            if([400,404].includes(error.response.status)) {
                this.message = error.response.data.message;
            }
        }).finally(() => {
            this.loading = false;
        })
    }
}
</script>

<style scoped>
.full-height {
    height: 100vh;
}
.full-width {
    max-width: 1140px;
    width: 100%;
}

.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}
</style>
