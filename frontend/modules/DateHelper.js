export default ({ app }, inject) => {
  inject('dateHyphen', (dateTime) => {
    if (dateTime === null || dateTime === undefined) {
      return ''
    }

    const date = new Date(dateTime)

    const formattedDate =
      date.getFullYear() +
      '-' +
      (date.getMonth() + 1).toString().padStart(2, '0') +
      '-' +
      date.getDate().toString().padStart(2, '0')

    return formattedDate
  })
}
