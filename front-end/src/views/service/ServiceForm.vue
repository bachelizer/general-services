<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form @submit.prevent="handleSubmit">
          <v-card-title>
            <span class="text-h5">Service Request Form</span>
          </v-card-title>
          <v-card-text>
            <v-card class="pa-5 mb-3" elevation="4">
              <v-row>
                <v-col cols="12">
                  <v-select
                    :readonly="
                      disableFulfilled || disableServed || disablePending || !disableCreate
                    "
                    v-model="data.office_id"
                    :items="offices"
                    item-text="office"
                    item-value="id"
                    label="Office"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12">
                  <v-radio-group v-model="data.service_id" row>
                    <div v-for="service in services" :key="service.id">
                      <v-radio
                        :readonly="disableFulfilled || disableServed || disablePending"
                        class="mt-3"
                        :label="service.service"
                        :value="service.id"
                      ></v-radio>
                    </div>
                  </v-radio-group>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    :readonly="disableFulfilled || disableServed || disablePending"
                    v-model="data.reason"
                    label="Details"
                    required
                  ></v-textarea>
                </v-col>
                <v-col cols="12">
                  <v-autocomplete
                    :readonly="disableFulfilled || disableServed || disablePending"
                    v-model="data.office_equipment_id"
                    :items="officeEquipments"
                    item-text="code"
                    item-value="id"
                    label="Equipment"
                    required
                    placeholder="Start typing.."
                  >
                  </v-autocomplete>
                </v-col> </v-row
            ></v-card>
            <div v-if="action !== 'create'">
              <v-card class="pa-5 mb-3" elevation="4">
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      :readonly="disableFulfilled || disableServed"
                      v-model="data.action_taken"
                      label="Action Taken"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="4">
                    <v-menu
                      ref="timeStartMenu"
                      v-model="timeStartMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="data.time_start"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="data.time_start"
                          label="Time started"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        :readonly="disableFulfilled || disableServed"
                        v-if="timeStartMenu"
                        v-model="data.time_start"
                        full-width
                        @click:minute="$refs.timeStartMenu.save(data.time_start)"
                      ></v-time-picker> </v-menu
                  ></v-col>
                  <v-col cols="4">
                    <v-menu
                      ref="timeEndMenu"
                      v-model="timeEndMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      :return-value.sync="data.time_end"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="data.time_end"
                          label="Time ended"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        :readonly="disableFulfilled || disableServed"
                        v-if="timeEndMenu"
                        v-model="data.time_end"
                        full-width
                        @click:minute="$refs.timeEndMenu.save(data.time_end)"
                      ></v-time-picker> </v-menu
                  ></v-col>
                  <v-col cols="4">
                    <v-menu
                      v-model="dateMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="data.date_served"
                          label="Date Served"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        :readonly="disableFulfilled || disableServed"
                        v-model="data.date_served"
                        @input="dateMenu = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col col>
                    <v-text-field
                      readonly
                      v-model="requestedBy"
                      label="Requested & Evaluated by:"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col col>
                    <v-select
                      v-if="!tickThirdParty"
                      :readonly="disableFulfilled || disableServed"
                      v-model="data.serve_by_id"
                      :items="maintener"
                      :item-text="x => `${x.last_name}, ${x.first_name}`"
                      item-value="id"
                      label="Served by"
                      required
                    ></v-select>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12">
                    <v-checkbox
                      :disabled="disableFulfilled || disableServed"
                      v-model="tickThirdParty"
                      label="3rd party service"
                    ></v-checkbox>
                  </v-col>
                  <v-col cols="12">
                    <v-select
                      v-if="tickThirdParty || data.serve_by_3rd_id"
                      :readonly="disableFulfilled || disableServed"
                      v-model="data.serve_by_3rd_id"
                      :items="outSources"
                      item-text="institution_name"
                      item-value="id"
                      label="Served by establisment"
                      required
                    ></v-select>
                  </v-col>
                </v-row>
              </v-card>
              <v-card v-if="disableFulfilled || disableServed" class="mb-3" elevation="4">
                <v-card-title>Evaluation</v-card-title>
                <div class="pa-5">
                  <v-row>
                    <v-col cols="12">
                      <v-radio-group
                        v-model="data.satisfaction"
                        justify-center
                        row
                        :readonly="disableFulfilled"
                      >
                        <div
                          class="size"
                          v-for="(satisfaction, index) in satisfactions"
                          :key="index"
                        >
                          <v-radio
                            class="mt-3 size"
                            :label="satisfaction"
                            :value="satisfaction"
                          ></v-radio>
                        </div>
                      </v-radio-group>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col col>
                      <v-textarea
                        v-model="data.remarks"
                        label="Remarks/Recommendations:"
                        :readonly="disableFulfilled"
                      >
                      </v-textarea>
                    </v-col>
                  </v-row>
                </div>
              </v-card>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="$emit('close')">
              Close
            </v-btn>
            <v-btn v-if="disableCreate" color="primary darken-1" text type="submit">
              Submit Request
            </v-btn>
            <div v-if="isAdmin">
              <v-btn
                v-if="disablePending && isGeneralServices"
                color="primary darken-1"
                text
                type="submit"
              >
                Serve
              </v-btn>
              <v-btn v-if="disableServed" color="primary darken-1" text type="submit">
                Fulfill
              </v-btn>
            </div>

            <v-btn v-if="disableFulfilled" color="primary darken-1" text type="submit">
              Print
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
  name: 'ServiceForm',
  props: {
    action: {
      type: String,
      default: '',
    },
    status: {
      type: String,
      default: '',
    },
    dialog: {
      type: Boolean,
      default: false,
    },
    data: {
      type: Object,
      default: Object,
    },
  },
  data() {
    return {
      satisfactions: ['Very Satisfied', 'Satisfied', 'Neutral', 'Unsatisfied', 'Very unsatisfied'],
      timeStartMenu: false,
      timeEndMenu: false,
      dateMenu: false,
      tickThirdParty: false,
    };
  },
  created() {
    this.onLoad();
  },
  methods: {
    ...mapActions('office', ['fetchOffice']),
    ...mapActions('equipment', ['fetchOfficeEquipment']),
    ...mapActions('service', [
      'fetchServices',
      'postMaintenance',
      'servedMaintenance',
      'evaluateMaintenance',
      'servicePDF',
    ]),
    ...mapActions('user', ['fetchUsers']),
    ...mapActions('outsource', ['fetchOutSources']),
    onLoad() {
      this.fetchOffice();
      this.fetchOfficeEquipment();
      this.fetchServices();
      this.fetchUsers();
      this.fetchOutSources();
    },
    async handleSubmit() {
      try {
        if (this.action === 'create' || this.status === '') {
          await this.postMaintenance(this.data);
          this.$emit('close');
        }
        if (this.status === 'pending') {
          // alert('SERVED ACTION!');
          // console.log(this.data)
          await this.servedMaintenance([this.data, this.data.id]);
        }
        if (this.status === 'served') {
          await this.evaluateMaintenance([this.data, this.data.id]);
        }
        if (this.status === 'fulfilled') {
          this.servicePDF(this.data.id);
        }
        this.$emit('close');
        this.$emit('reload');
      } catch (error) {
        alert(error);
      }
    },
    // async loadSources() {
    //   this.fetchOutSources();
    // },
  },
  computed: {
    ...mapState('office', ['offices']),
    ...mapState('equipment', ['officeEquipments']),
    ...mapState('service', ['services']),
    ...mapState('user', ['users']),
    ...mapState('auth', ['userCredential']),
    ...mapState('outsource', ['outSources']),
    requestedBy() {
      if (this.action === 'create') return '';
      else if (this.data.request_by != null) {
        return `${this.data.request_by.last_name}, ${this.data.request_by.first_name}`;
      } else {
        return null;
      }
    },
    servedBy() {
      return `${this.data.served_by.last_name}, ${this.data.served_by.first_name}`;
    },
    disableFulfilled() {
      return this.action === 'create' ? false : this.status === 'fulfilled';
    },
    disableServed() {
      return this.action === 'create' ? false : this.status === 'served';
    },
    disablePending() {
      return this.action === 'create' ? false : this.status === 'pending';
    },
    disableCreate() {
      return this.action === 'create';
    },
    maintener() {
      return this.users.filter(x => x.office.id === 1);
    },
    isAdmin() {
      return this.userCredential.data.role_id !== 3;
    },
    isGeneralServices() {
      return this.userCredential.data.office_id === 1;
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
