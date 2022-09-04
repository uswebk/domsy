export default async function ({ store, redirect, route }) {
  const routePath = route.path

  if (routePath === '/') return

  try {
    await store.dispatch('authentication/fetchMe')
    const user = store.state.authentication.me

    // 未ログイン
    if (user === null) {
      if (routePath === '/login') {
        return
      }
      if(!isNotAuthenticatePathByRoute(routePath)){
        redirect('/login')
      }
      return
    }

    const emailVerifiedAt = user.email_verified_at
    // メール未認証
    if (emailVerifiedAt === null && routePath !== '/verify') {
      redirect('/verify')
    }
    // メール認証済
    if (emailVerifiedAt !== null && isNotAuthenticatePathByRoute(routePath)) {
      redirect('/mypage')
    }
    return
  } catch (error) {
    redirect('/login')
  }
}

function isNotAuthenticatePathByRoute(routePath) {
  const pattern1 = /^\/password\/reset\/[\w]+/
  const pattern2 = /^\/api\/verify\/url\/[\w]+/
  const result1 = pattern1.test(routePath)
  const result2 = pattern2.test(routePath)

  if (result1 || result2) return true

  const targetRoute = ['/', '/login', '/register', '/password/email']
  return targetRoute.includes(routePath)
}
