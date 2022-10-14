<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="300">
      <v-card>
        <v-form @submit.prevent="$emit('submit', rejection_remarks)">
            <v-card-title class="text-h6">
          Rejection Remarks
        </v-card-title>
        <v-card-text>
          <v-textarea v-model="rejection_remarks" outlined> </v-textarea>
        </v-card-text>
          <v-card-actions class="mx-auto">
            <v-spacer></v-spacer>
            <v-btn color="default darken-1" @click="$emit('close')">
              Cancel
            </v-btn>
            <v-btn color="error darken-1" type="submit">
              Reject
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: 'RejectionDialog',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      rejection_remarks: '',
    };
  },
};
</script>
