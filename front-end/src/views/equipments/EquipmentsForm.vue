<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form @submit.prevent="handleSubmit">
          <v-card-title>
            <span class="text-h5">Equipment Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col>
                <v-text-field outlined v-model="equipment" label="Equipment Name"></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4">
                <v-checkbox v-model="isMainten" label="Maintenance"></v-checkbox>
              </v-col>
              <v-col cols>
                <v-select
                  v-model="maintenanceInterval"
                  :disabled="!isMainten"
                  outlined
                  :items="maintenanceIntervals"
                  label="Maintenance Interval"
                  :item-text="x => (isMainten ? x.desc : '')"
                  item-value="days"
                >
                </v-select>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="$emit('close')">
              Close
            </v-btn>
            <v-btn color="primary darken-1" text type="submit">
              Add
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
export default {
  name: 'OfficeForm',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      equipment: '',
      isMainten: false,
      maintenanceInterval: null,
      maintenanceIntervals: [
        {
          desc: 'Weekly',
          days: 7,
        },
        {
          desc: 'Monthly',
          days: 31,
        },
        {
          desc: 'Semiannually',
          days: 180,
        },
        {
          desc: 'Anually',
          days: 365,
        },
      ],
    };
  },
  created() {},
  methods: {
    clear() {
      this.equipment = '';
      this.isMainten = false;
      this.maintenanceInterval = null;
    },
    async handleSubmit() {
      const payload = {
        equipment: this.equipment,
        maintenance_interval: this.isMainten ? this.maintenanceInterval : null,
      };
      // console.log(payload);
      await this.$store.dispatch('equipment/createEquipment', payload);
      this.clear();
      this.$emit('close');
      this.$emit('reload');
    },
  },
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
