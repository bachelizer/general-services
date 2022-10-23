<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form @submit.prevent="$emit('submit', payload)">
          <v-card-title>
            <span class="text-h5">Inventory Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="6">
                <v-text-field
                  v-model="payload.available_stock"
                  label="Available stock + "
                ></v-text-field>
              </v-col>

              <v-col cols="6">
                <v-text-field readonly v-model="payload.unit" label="Unit"></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="$emit('close')">
              Close
            </v-btn>
            <v-btn color="primary darken-1" text type="submit">
              Add Stock
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  name: 'InventoryReplenishForm',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    payload: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      units: ['kl.', 'sacks', 'bottle', 'box', 'sachet'],
    };
  },
  created() {},
  methods: {},
  computed: {},
};
</script>
<style scoped>
.small-radio {
  font-size: 12px;
}
.small-radio label {
  font-size: 10px;
  padding-left: 0px;
  margin-left: -4px;
}
.small-radio .v-radio {
  padding: 0px;
}
.small-radio [class*='__ripple'] {
  left: 0;
}
.size {
  font-size: 10px;
}
</style>
