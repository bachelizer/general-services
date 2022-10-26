<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px" transition="dialog-top-transition">
      <v-card>
        <v-form ref="form" @submit.prevent="handleSubmit">
          <v-card-title>
            <span class="text-h5">Borrow Request Form</span>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="8">
                <v-autocomplete
                  :readonly="disableField"
                  v-model="data.equipment_id"
                  label="General Service Equipment"
                  :items="generalServicesEquipments"
                  item-text="code"
                  item-value="id"
                  required
                  :rules="required"
                >
                  ></v-autocomplete
                >
              </v-col>
              <v-col cols="4">
                <v-text-field
                  :readonly="disableField"
                  label="Qty."
                  v-model.number="data.qty"
                  required
                  :rules="validateNumber"
                >
                </v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <v-textarea
                  :readonly="disableField"
                  label="Purpose"
                  v-model="data.purpose"
                  required
                  :rules="required"
                >
                </v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col v-if="data.approval_status === 'Rejected'">
                <v-textarea
                  rules="Required"
                  required
                  :readonly="disableField"
                  label="Rejection Remarks"
                  v-model="data.rejection_remarks"
                >
                </v-textarea>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" text @click="close">
              Close
            </v-btn>
            <v-btn v-if="action === 'create'" color="primary darken-1" text type="submit">
              Submit Request
            </v-btn>
            <div v-if="data.approval_status === 'Pending' && isAdmin">
              <v-btn @click="rejectDialog" color="error darken-1" text>
                Reject
              </v-btn>
              <v-btn @click="consent" color="success darken-1" text>
                forward to OP
              </v-btn>
            </div>
            <v-btn
              v-if="isOP && action === 'consent'"
              @click="approve"
              color="success darken-1"
              text
            >
              Approve
            </v-btn>
            <v-btn
              v-if="
                data.approval_status === 'Rejected' ||
                  data.approval_status === 'Approved' ||
                  data.approval_status === 'Returned'
              "
              color="success darken-1"
              text
              type="submit"
            >
              print
            </v-btn>
            <v-btn
              v-if="data.approval_status === 'Approved'"
              color="primary darken-1"
              text
              @click="returned"
            >
              Returned
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    <rejection-dialog
      :dialog="rejectionDialog"
      @close="rejectionDialog = false"
      @submit="reject"
    ></rejection-dialog>
  </v-row>
</template>
<script>
import { mapActions, mapState } from 'vuex';
import RejectionDialog from '@/components/dialogs/RejectionDialog.vue';

export default {
  components: { RejectionDialog },
  name: 'BorrowForm',
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
      rejectionDialog: false,
      required: [
        v => !!v || 'this field is required',
        // v => (v && v.length <= 10) || 'Name must be less than 10 characters',
      ],
      validateNumber: [
        v => !!v || 'this field is required',
        v => /[0-9]/.test(v) || 'Quantity must be number',
      ],
    };
  },
  mounted() {},
  created() {
    this.$store.dispatch('equipment/fetchOfficeEquipment');
  },
  methods: {
    ...mapActions('borrow', [
      'postBorrows',
      'approveBorrow',
      'consentBorrow',
      'rejectBorrow',
      'returnBorrow',
      'printForm',
    ]),
    reload() {
      this.$emit('reload');
    },
    async close() {
      this.$refs.form.resetValidation();
      this.$emit('close');
    },
    async handleSubmit() {
      this.$refs.form.validate();
      try {
        if (this.action === 'create') {
          await this.postBorrows(this.data);
          this.reload();
        } else {
          this.printForm(this.data);
        }
        this.close();
      } catch (error) {
        alert(error);
      }
    },
    async rejectDialog() {
      this.rejectionDialog = true;
    },
    async reject(remarks) {
      try {
        const payload = {
          rejection_remarks: remarks,
          approver_id: this.userCredential.data.user_id, // take the user_id from the state
        };
        await this.rejectBorrow([payload, this.data.id]);
        this.rejectionDialog = false;
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
    // forward to OP
    async consent() {
      try {
        const payload = {
          approver_id: this.userCredential.data.user_id, // take the user_id from the state
        };
        await this.consentBorrow([payload, this.data.id]);
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
    async approve() {
      try {
        const payload = {
          approver_id: this.userCredential.data.user_id, // take the user_id from the state
        };
        await this.approveBorrow([payload, this.data.id]);
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
    async returned() {
      try {
        await this.returnBorrow(this.data.id);
        this.reload();
        this.$emit('close');
      } catch (e) {
        alert(e.message);
      }
    },
  },
  computed: {
    ...mapState('equipment', ['officeEquipments']),
    ...mapState('auth', ['userCredential']),
    generalServicesEquipments() {
      return this.officeEquipments.filter(x => x.office_id === 1);
    },
    disableField() {
      return this.action !== 'create';
    },
    isAdmin() {
      return this.userCredential.data.role_id !== 3;
    },
    isOP() {
      return this.userCredential.data.office_id === 3 && this.userCredential.data.role_id !== 3;
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
