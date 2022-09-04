export default async function ({ store, redirect, route }) {
  if (isNotAuthenticatePath(route)) return

  try {
    await store.dispatch('authentication/fetchMe')
    const user = store.state.authentication.me

    if (user === null) {
      redirect('/login')
    }
    if (user.email_verified_at !== null && route.path === '/verify') {
      redirect('/mypage')
    }
    if (user.email_verified_at === null && route.path !== '/verify') {
      redirect('/verify')
    }
  } catch (error) {
    redirect('/login')
  }
}

function isNotAuthenticatePath(route) {
  const pattern1 = /^\/password\/reset\/[\w]+/
  const pattern2 = /^\/api\/verify\/url\/[\w]+/
  const result1 = pattern1.test(route.path)
  const result2 = pattern2.test(route.path)

  if (result1 || result2) return true

  const targetRoute = ['/', '/login', '/register', '/password/email']
  return targetRoute.includes(route.path)
}
