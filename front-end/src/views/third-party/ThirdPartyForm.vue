<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="500">
      <v-card>
        <v-form @submit.prevent="$emit('submit', data)">
          <v-card-title class="text-h6">
            Third party form
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-text-field v-model="data.institution_name" outlined label="Establishment Name">
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="data.owner" outlined label="Owner"></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions class="mx-auto">
            <v-spacer></v-spacer>
            <v-btn color="default darken-1" @click="$emit('close')" type="reset">
              Cancel
            </v-btn>
            <v-btn color="primary darken-1" type="submit">
              Submit
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    data: {
      type: Object,
    },
    action: {
      type: String,
    },
  },
  data() {
    return {
      params: {
        action_taken: '',
        maintainedBy: Number,
      },
    };
  },
  created() {},
  methods: {},
  computed: {},
};
</script>
