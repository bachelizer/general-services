<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form @submit.prevent="$emit('submit', payload, id)">
          <v-card-title>
            <span class="text-h5">Despense Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="6">
                <v-text-field
                  v-model="payload.use_stock"
                  label="Number of stock to be use"
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
              Use Stock
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  name: 'InventoryDespenseForm.vue',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    payload: {
      type: Object,
      default: () => {},
    },
    id: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {};
  },
  created() {},
  methods: {},
  computed: {},
};
</script>
