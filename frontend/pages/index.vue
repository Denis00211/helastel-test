<template>
  <section class="section">
    <div class="container">
      <h2 class="title">My Profile</h2>
      <div class="content">
        <p>
          <strong>Id:</strong>
          {{ loggedInUser.id }}
        </p>
        <p>
          <strong>Email:</strong>
          {{ loggedInUser.email }}
        </p>
        <div class="control">
          <nuxt-link to="/added-information">
            <button type="submit" class="button is-dark">Added information</button>
          </nuxt-link>
        </div>

        <div class="control">
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',
  computed: {
    ...mapGetters(['loggedInUser'])
  }
}
</script>
