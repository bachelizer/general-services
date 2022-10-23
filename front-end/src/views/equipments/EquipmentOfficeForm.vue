<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form @submit.prevent="handleSubmit">
          <v-card-title>
            <span class="text-h5">Office Equipment Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="8">
                <v-autocomplete
                  required
                  v-model="data.user_id"
                  label="Custodian"
                  :items="custodian"
                  :item-text="
                    x => `${x.last_name}, ${x.first_name} ${x.middle_name.substr(0, 1)}. `
                  "
                  item-value="id"
                ></v-autocomplete>
              </v-col>
              <v-col cols="4">
                <v-autocomplete
                  required
                  v-model="data.equipment_id"
                  label="Equipment"
                  :items="equipments"
                  item-text="equipment"
                  item-value="id"
                  @change="regularMaintenance"
                ></v-autocomplete>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="6">
                <v-text-field
                  required
                  v-model="data.code"
                  label="Equipment Code"
                  item-text="code"
                  item-value="id"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  required
                  v-model="data.serial"
                  label="Serial #"
                  item-text="code"
                  item-value="id"
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="4">
                <v-text-field
                  required
                  v-model="data.amount"
                  label="Amount"
                  item-text="code"
                  item-value="id"
                ></v-text-field>
              </v-col>
              <v-col cols="8">
                <v-text-field
                  v-model="data.supplier"
                  label="Supplier"
                  item-text="code"
                  item-value="id"
                ></v-text-field>
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
import { mapActions, mapState } from 'vuex';

export default {
  name: 'EquipmentOfficeForm',
  props: {
    officeId: {
      type: Number,
      default: 0,
    },
    dialog: {
      type: Boolean,
      default: false,
    },
    data: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
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
  created() {
    this.onLoad();
  },
  methods: {
    ...mapActions('user', ['fetchUsers']),
    ...mapActions('equipment', ['fetchEquipment', 'creatOfficeEquipment']),
    onLoad() {
      this.fetchUsers();
      this.fetchEquipment();
    },
    async handleSubmit() {
      // alert('data');
      const payload = { ...this.data, office_id: this.officeId };
      try {
        await this.creatOfficeEquipment(payload);
        this.onLoad();
        this.$emit('close');
      } catch (e) {
        console.log(e);
        alert(e.message);
      }
    },
    regularMaintenance() {
      const equipment = this.equipments.filter(x => x.id === this.data.equipment_id);
      this.data.maintenance_day = equipment[0].maintenance_interval;
    },
  },
  computed: {
    ...mapState('user', ['users']),
    ...mapState('equipment', ['equipments']),
    custodian() {
      return this.users.filter(x => x.office.id === this.officeId);
    },
  },
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
