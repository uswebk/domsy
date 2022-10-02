export default async function ({ store, route }) {
  await store.dispatch('authentication/fetchMe')
  const user = store.state.authentication.me
  // ログイン済みかつメール認証済み
  if (user !== null && Object.keys(user).length > 0) {
    if (user.email_verified_at !== null) {
      await store.dispatch('role/fetchRoleItems')
      const roleItems = store.state.role.roleItems
      const endpoints = roleItems.map((roleItem) => roleItem.endpoint)
      if (endpoints.includes(route.path)) {
        await store.dispatch('hasRole', route.path)
      }
    }
  }
}
