<template>
  <section class="section">
    <div class="container">
      <div class="columns">
        <div class="column is-4 is-offset-4">
          <h6 class="title has-text-centered">Data addition</h6>

          <Notification :message="error" v-if="error"/>

          <form method="post" @submit.prevent="addedInformation">
            <div class="field">
              <label class="label">Name</label>
              <div class="control">
                <input
                  type="text"
                  class="input"
                  name="name"
                  required
                  v-model="name"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Surname</label>
              <div class="control">
                <input
                  type="text"
                  class="input"
                  name="surname"
                  required
                  v-model="surname"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Patronymic</label>
              <div class="control">
                <input
                  type="text"
                  class="input"
                  name="patronymic"
                  required
                  v-model="patronymic"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  type="email"
                  class="input"
                  name="email"
                  required
                  v-model="email"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Phone</label>
              <div class="control">
                <input
                  type="tel"
                  class="input"
                  name="phone"
                  required
                  v-model="phone"
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Type</label>
              <div class="control">
                <select
                  class="input"
                  name="type"
                  required
                  v-model="selectedType"
                >
                  <option v-for="type in types" :key="type.name" :value="type.name">{{type.title}}</option>
                </select>
              </div>
            </div>
            <div class="control">
              <button type="submit" class="button is-dark is-fullwidth">Add</button>
            </div>
          </form>
          </div>
        </div>
      </div>
  </section>
</template>

<script>
import Notification from '~/components/Notification'

export default {
  components: {
    Notification,
  },

  data() {
    return {
      email: '',
      name: '',
      surname: '',
      patronymic: '',
      phone: '',
      selectedType:null,
      error: null,
      types: [
        {name:'db', title: 'DB'},
        {name:'cache', title: 'Cache'},
        {name:'json', title: 'Json'},
        {name:'xlsx', title: 'Xlsx'}
      ],
    }
  },

  methods: {
    async addedInformation() {
      try {
        const response = await this.$axios.post('user-info', {
          email: this.email,
          name: this.name,
          surname: this.surname,
          patronymic: this.patronymic,
          phone: this.phone,
          type: this.selectedType,
        })

        if(response.data.error_code !== 0) {
          this.error = response.data.message
        } else {
          await this.$router.push('/')
        }
      } catch (e) {
        this.error = e.response.data.message
      }
    }
  }
}
</script>
