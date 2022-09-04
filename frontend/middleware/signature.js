export default async function ({ store, redirect, route }) {
  if (!isVerificationPath(route)) return

  try {
    const result = await store.dispatch('verifyUrl', route)
    if (result.data.status === 'success') {
      redirect('/')
    }
    if (result.data.status === 'already') {
      redirect('/mypage')
    }
  } catch (error) {
    redirect('/')
  }
}

function isVerificationPath(route) {
  const pattern = /^\/api\/verify\/url\/[\w]+/
  return pattern.test(route.path)
}
