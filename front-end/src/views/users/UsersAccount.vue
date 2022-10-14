<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="300">
      <v-card>
        <v-form @submit.prevent="$emit('submit', account)">
          <v-card-title class="text-h6">
            Account form
          </v-card-title>
          <v-card-text>
            <v-text-field label="username" v-model="account.username"></v-text-field>
            <v-text-field label="password" v-model="account.password"></v-text-field>
          </v-card-text>
          <v-card-actions class="mx-auto">
            <v-spacer></v-spacer>
            <v-btn type="reset" color="default darken-1" @click="$emit('close'), (account = {})">
              Cancel
            </v-btn>
            <v-btn color="error darken-1" type="submit">
              Create
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: 'UsersAccount',
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      account: {
        username: '',
        password: '',
      },
    };
  },
};
</script>
