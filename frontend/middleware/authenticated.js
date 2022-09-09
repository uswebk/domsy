export default async function ({ store, redirect, route }) {
  const routePath = route.path
  if (routePath === '/') return

  try {
    await store.dispatch('authentication/fetchMe')
    const user = store.state.authentication.me
    // 未ログイン
    if (user === null) {
      if (isAuthPath(routePath)) {
        redirect('/login')
      }
      return
    }
    // メール未認証
    if (user.email_verified_at === null && routePath !== '/verify') {
      redirect('/verify')
    }
    // メール認証済
    if (user.email_verified_at !== null && !isAuthPath(routePath)) {
      redirect('/mypage')
    }
    // 個人でアカウントページアクセス
    if (!user.is_company && routePath === '/account') {
      return this.$nuxt.error({ statusCode: 403, message: 'Forbidden' })
    }
  } catch (error) {
    redirect('/login')
  }
}

function isAuthPath(routePath) {
  const pattern = /^\/password\/reset\/[\w]+/
  const result1 = pattern.test(routePath)

  if (result1) return false

  const targetRoute = ['/login', '/register', '/password/email']
  return !targetRoute.includes(routePath)
}
