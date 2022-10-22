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
              <v-col cols="4">
                <v-text-field
                  v-model="payload.inventory_name"
                  label="Short name"
                  placeholder="eg. Downy (sachet)"
                ></v-text-field>
              </v-col>
              <v-col cols="8">
                <v-text-field v-model="payload.name" label="Inventory long name" placeholder="Downy Anti-Kulob"></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field v-model="payload.base_stock" label="QTY."></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-select
                  label="Unit"
                  :items="units"
                  v-model="payload.unit"
                  item-text="unit"
                  item-value="unit"
                ></v-select>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="$emit('close')">
              Close
            </v-btn>
            <v-btn color="primary darken-1" text type="submit">
              Add Inventory
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  name: 'InventoryForm',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      payload: {
        inventory_name: '',
        name: '',
        base_stock: 0,
        unit: '',
      },
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
