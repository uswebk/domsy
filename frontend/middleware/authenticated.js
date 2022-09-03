export default async function ({ store, redirect, route }) {
  if (isNotAuthenticatePath(route)) {
    return
  }
  try {
    await store.dispatch('authentication/checkLogin')

    if(!store.state.authentication.isLogin){

      redirect('/')
    }
     // ページ表示roleを持っているかサーバーに問い合わせ

  } catch (error) {
  }
}

function isNotAuthenticatePath(route) {
  const targetRoute = ['/', '/login']

  return targetRoute.includes(route.path)
}
