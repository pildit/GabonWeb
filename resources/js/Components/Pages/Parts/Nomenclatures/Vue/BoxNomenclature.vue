<template>
  <div class="col-md-6 col-lg-4 p-4">
    <div class="card">
          <div class="card-body">
              <h2 class="font-weight-bold my-4">
                <a :href="item.link" class="btn btn-light-blue btn-rounded">{{ item.title }}</a>
              </h2>
              <p v-if="item.text" class="grey-text">{{ item.text }}</p>
          </div>
    </div>
  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";

    export default  {
        props: {
          item: Object
        },
        mixins: [Translation],
        created() {
        }
    }

</script>