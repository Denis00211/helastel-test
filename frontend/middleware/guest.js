export default function ({ store, redirect }) {
  if (store.state.auth.loggedIn) {
    return redirect('/')
  } else {
    return redirect('/login')
  }
}
