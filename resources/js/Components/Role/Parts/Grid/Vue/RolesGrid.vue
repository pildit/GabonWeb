<template>
    <div class="container-fluid">
        <h5 class="text-center green-text"></h5>
        <vue-pagination :pagination="roles" @paginate="getRoles()" :offset="4"></vue-pagination>
    </div>
</template>

<script>
import VuePagination from "components/Common/VuePagination";
import Translation from "../../../../Mixins/Translation";

export default {
    data() {
        return {
            roles: {
                total: 0,
                per_page: 2,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4
        }
    },
    components: {VuePagination},
    mounted() {
      this.getRoles();
    },
    methods: {
        updateResource() {
            console.log('UPDATE RES');
        },
        getRoles() {
          this.roles = {
              "current_page": 1,
              "data": [
                  {
                      "id": 22,
                      "name": "permit_items.create"
                  },
                  {
                      "id": 21,
                      "name": "permit_items.view_own"
                  },
                  {
                      "id": 20,
                      "name": "permit_items.view"
                  },
                  {
                      "id": 19,
                      "name": "permits.viewown"
                  },
                  {
                      "id": 18,
                      "name": "users.edit"
                  },
                  {
                      "id": 17,
                      "name": "posts"
                  },
                  {
                      "id": 16,
                      "name": "users.*"
                  },
                  {
                      "id": 15,
                      "name": "permits.edit"
                  },
                  {
                      "id": 14,
                      "name": "users.create"
                  },
                  {
                      "id": 13,
                      "name": "users.view_own"
                  },
                  {
                      "id": 12,
                      "name": "users.view"
                  },
                  {
                      "id": 11,
                      "name": "permits.view_own"
                  },
                  {
                      "id": 10,
                      "name": "permits.view"
                  }
              ],
              "first_page_url": "http:\/\/127.0.0.1:8000\/api\/permissions?page=1",
              "from": 1,
              "last_page": 2,
              "last_page_url": "http:\/\/127.0.0.1:8000\/api\/permissions?page=2",
              "next_page_url": null,
              "path": "http:\/\/127.0.0.1:8000\/api\/permissions",
              "per_page": 10,
              "prev_page_url": null,
              "to": 10,
              "total": 13
          }
        }
    }
}
</script>

<style scoped>

</style>
